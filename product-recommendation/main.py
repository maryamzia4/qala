import pandas as pd
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from sqlalchemy import create_engine
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.preprocessing import StandardScaler
import json

app = FastAPI()

# MySQL Database Connection using SQLAlchemy
DB_URL = "mysql+pymysql://root:@127.0.0.1:3306/qalafinal"
engine = create_engine(DB_URL)

# CORS setup
app.add_middleware(
    CORSMiddleware,
    allow_origins=["http://127.0.0.1:8000"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Function to test DB connection
def test_db_connection():
    try:
        with engine.connect() as conn:
            print("🔵 Database connection successful.")
            return True
    except Exception as e:
        print("❌ Database connection failed:", e)
        return False

test_db_connection()

# Fetch data using SQL queries
def fetch_data():
    try:
        interactions_df = pd.read_sql("SELECT user_id, product_id, interaction FROM interactions", engine)
        products_df = pd.read_sql("SELECT id, name FROM products", engine)  # Add other columns if needed

        print("Interactions DataFrame:", interactions_df.head())  # Debug: print first few rows of interactions
        print("Products DataFrame:", products_df.head())  # Debug: print first few rows of products

        return interactions_df, products_df
    except Exception as e:
        print("❌ Error fetching data from DB:", e)
        return pd.DataFrame(), pd.DataFrame()

# Recommendation logic
def recommend_products(user_id: int, top_n: int = 5):
    interactions_df, products_df = fetch_data()

    if interactions_df.empty or products_df.empty:
        print("❌ No data available in interactions or products.")
        return {"recommendations": []}

    if user_id not in interactions_df['user_id'].unique():
        print(f"❌ User {user_id} has no interactions.")
        return {"recommendations": []}

    # Create user-product interaction matrix
    user_product_matrix = interactions_df.pivot_table(
        index='user_id', columns='product_id', values='interaction', aggfunc='mean'
    ).fillna(0)
    
    print(f"User-Product Matrix for user {user_id}:\n{user_product_matrix.head()}")

    # Standardize the interaction data (scaling)
    scaler = StandardScaler()
    user_product_matrix_scaled = scaler.fit_transform(user_product_matrix)

    # Compute cosine similarity between users
    user_similarities = cosine_similarity(user_product_matrix_scaled)
    user_sim_df = pd.DataFrame(user_similarities, index=user_product_matrix.index, columns=user_product_matrix.index)
    
    print("User Similarity Matrix:\n", user_sim_df)

    # Find similar users to the given user
    similar_users = user_sim_df[user_id].sort_values(ascending=False).index[1:top_n+1]
    print(f"Similar users for user {user_id}: {similar_users}")

    # Get the products that the user has interacted with
    user_interacted_products = set(
        interactions_df[interactions_df['user_id'] == user_id]['product_id']
    )
    print(f"User {user_id} has interacted with products: {user_interacted_products}")

    # If user has interacted with all products, recommend top-rated products
    if user_interacted_products == set(user_product_matrix.columns):
        print(f"User {user_id} has already interacted with all products.")
        
        # Recommend top-rated products across all users
        top_rated_products = interactions_df.groupby('product_id').sum()['interaction'].sort_values(ascending=False).head(top_n)
        top_rated_product_ids = top_rated_products.index
        recommended_products_df = products_df[products_df['id'].isin(top_rated_product_ids)]
        
        # Return the recommended products in the response
        return {"recommendations": recommended_products_df.to_dict(orient='records')}

    # Recommend based on similar users' interactions
    similar_users_interactions = interactions_df[interactions_df['user_id'].isin(similar_users)]
    recommended_products = similar_users_interactions[
        ~similar_users_interactions['product_id'].isin(user_interacted_products)
    ]
    recommended_products = recommended_products.groupby('product_id').sum()['interaction'].sort_values(ascending=False).head(top_n)
    recommended_product_ids = recommended_products.index
    recommended_products_df = products_df[products_df['id'].isin(recommended_product_ids)]
    
    return {"recommendations": recommended_products_df.to_dict(orient='records')}


# API route
@app.get("/recommend/{user_id}")
def get_recommendations(user_id: int, top_n: int = 5):
    recommendations = recommend_products(user_id, top_n)
    return {"user_id": user_id, "recommendations": recommendations}

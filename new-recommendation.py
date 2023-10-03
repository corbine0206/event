import sys
import json
import numpy as np
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

try:
    # Get the file path from command-line arguments
    if len(sys.argv) < 2:
        print("Usage: python new-recommendation.py <file_path>")
        sys.exit(1)

    file_path = sys.argv[1]

    # Read the JSON data from the file
    with open(file_path, 'r') as file:
        data = file.read()

    # Attempt to parse the JSON data
    data_dict = json.loads(data)

    # Extract user preferences and dataset
    user_preferences = data_dict.get("user_preferences", [])
    dataset = data_dict.get("dataset", [])

    # Check if user_preferences and dataset are not empty
    if not user_preferences:
        print("Error: Empty user preferences")
        sys.exit(1)

    if not dataset:
        print("Error: Empty dataset")
        sys.exit(1)

    # Combine user preferences and dataset into a list of documents
    documents = user_preferences + [entry.get("technology_line", "") for entry in dataset]

    # Create a TF-IDF vectorizer to convert text data into numerical form
    vectorizer = TfidfVectorizer()
    tfidf_matrix = vectorizer.fit_transform(documents)

    # Calculate pairwise cosine similarities
    similarities = cosine_similarity(tfidf_matrix)

    # Find the most similar technology line for each user preference
    user_preference_scores = similarities[:len(user_preferences), len(user_preferences):]

    # Find the technology line index with the highest similarity for each user preference
    best_matches = np.argmax(user_preference_scores, axis=1)

    # Print the best matches with session_title, date1, time1, and time2
    for i, preference in enumerate(user_preferences):
        best_match_index = best_matches[i]
        best_match_entry = dataset[best_match_index]
        print(f"User Preference: {preference}")
        print(f"Best Match Technology Line: {best_match_entry.get('technology_line', '')}")
        print(f"Session Title: {best_match_entry.get('session_title', '')}")
        print(f"Date1: {best_match_entry.get('date1', '')}")
        print(f"Time1: {best_match_entry.get('time1', '')}")
        print(f"Time2: {best_match_entry.get('time2', '')}")
        print(f"Cosine Similarity Score: {user_preference_scores[i, best_match_index]}")
        print("\n")

except Exception as e:
    print("Error:", str(e))
    sys.exit(1)

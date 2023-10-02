import sys
import json

def load_json_file(json_file):
    try:
        with open(json_file, 'r') as file:
            return json.load(file)
    except Exception as e:
        raise ValueError(f"Error loading JSON file: {e}")

def recommend_sessions(user_preferences, dataset):
    selected_technology_line = user_preferences.get('technology_line', '')
    selected_data = user_preferences.get('selected_data', '').split(',')

    recommended_sessions = []

    for entry in dataset:
        if entry.get('technology_line', '') == selected_technology_line and any(data in entry.get('technology_name', '') for data in selected_data):
            recommended_sessions.append({
                'session_id': entry.get('session_id', ''),
                'technology_line': entry.get('technology_line', ''),
                'product_id': entry.get('product_id', '')
            })

    return recommended_sessions

def main():
    if len(sys.argv) != 2:
        print("Usage: python new-recommendation.py <json_file>")
        return

    json_file = sys.argv[1]

    data = load_json_file(json_file)

    # Debug: Output received JSON data
    print("Received JSON data:")
    print(json.dumps(data, indent=4))

    user_preferences = data.get('user_preferences', {})
    dataset = data.get('dataset', [])

    # Your processing logic here
    recommended_sessions = recommend_sessions(user_preferences, dataset)

    # Debug: Output recommended_sessions
    print("Recommended Sessions:")
    print(json.dumps(recommended_sessions, indent=4))

    # Return the recommended sessions as JSON
    response = {'recommended_sessions': recommended_sessions}
    print(json.dumps(response))

if __name__ == "__main__":
    main()

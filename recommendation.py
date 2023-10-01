import sys
import pymysql
from datetime import datetime
import json

# Database connection setup
conn = pymysql.connect(
    host='localhost',       # Use your DB_SERVER value here
    user='root',            # Use your DB_USERNAME value here
    password='',            # Use your DB_PASSWORD value here
    database='event'        # Use your DB_NAME value here
)
cursor = conn.cursor()

# Guest's selected product names (replace with actual data from PHP)
selected_data_str = sys.argv[1] if len(sys.argv) > 1 else ""
selected_data = selected_data_str.split(",") if selected_data_str else []

# Get the current datetime
current_datetime = datetime.now()

# Try to get a recommended session based on exact matches for date1, time1, and time2
cursor.execute("""
    SELECT DISTINCT es.session_id, es.date1, es.time1, es.time2, es.session_title, es.event_id, p.technology_line, p.product_id
    FROM event_sessions AS es
    JOIN product_technology_lines AS p ON es.session_id = p.session_id
    WHERE p.technology_line IN ("tech line 1", "tech line 1", "tech line 1")
    AND NOT EXISTS (
        SELECT 1
        FROM event_sessions AS s
        WHERE s.date1 = es.date1
        AND s.time1 = es.time1
        AND s.time2 = es.time2
        AND (
            s.session_id <> es.session_id  # Exclude the current session
        )
    )
""", selected_data)  # Pass the tuple directly

recommended_sessions = cursor.fetchall()

# If no exact matches were found, get a recommended session without considering the schedule
if not recommended_sessions:
    cursor.execute("""
        SELECT DISTINCT es.session_id, es.date1, es.time1, es.time2, es.session_title, es.event_id, p.technology_line, p.product_id
        FROM event_sessions AS es
        JOIN product_technology_lines AS p ON es.session_id = p.session_id
        WHERE p.technology_line IN ("tech line 1", "tech line 1", "tech line 1")

    """, selected_data)  # Pass the tuple directly

    recommended_sessions = cursor.fetchall()

# Close database connection
conn.close()

# Print or return recommended sessions
print(json.dumps(recommended_sessions))

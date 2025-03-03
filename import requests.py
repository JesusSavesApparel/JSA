import requests

# Replace this with your actual Printify API token
API_TOKEN = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzN2Q0YmQzMDM1ZmUxMWU5YTgwM2FiN2VlYjNjY2M5NyIsImp0aSI6IjdiMzhlZGRlNmMyYzBlMjhkMTMwOTM5NmYwZTQ2MThhM2JkMTkxZWU5ZjZlMDJkYjM0N2Y0ZTVmYTA0YzEyMzY4ZTg3MTBmY2EyMjgzZWZiIiwiaWF0IjoxNzM2ODY0OTUxLjc2MDQwMiwibmJmIjoxNzM2ODY0OTUxLjc2MDQwNCwiZXhwIjoxNzY4NDAwOTUxLjc1MzQ3NSwic3ViIjoiMjAzOTkxMjEiLCJzY29wZXMiOlsic2hvcHMubWFuYWdlIiwic2hvcHMucmVhZCIsImNhdGFsb2cucmVhZCIsIm9yZGVycy5yZWFkIiwib3JkZXJzLndyaXRlIiwicHJvZHVjdHMucmVhZCIsInByb2R1Y3RzLndyaXRlIiwid2ViaG9va3MucmVhZCIsIndlYmhvb2tzLndyaXRlIiwidXBsb2Fkcy5yZWFkIiwidXBsb2Fkcy53cml0ZSIsInByaW50X3Byb3ZpZGVycy5yZWFkIiwidXNlci5pbmZvIl19.AO6LRFHFHLa4H5RNTyDFX1LAMBhE7v9rY_yhhK5gJSVrclxH-gEJAogNwtpC22tezqVdYAIzTw74SW-9xLE"

# Base API URL
BASE_URL = "https://api.printify.com/v1/"

# Headers for authentication
HEADERS = {
    "Authorization": f"BearereyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzN2Q0YmQzMDM1ZmUxMWU5YTgwM2FiN2VlYjNjY2M5NyIsImp0aSI6IjdiMzhlZGRlNmMyYzBlMjhkMTMwOTM5NmYwZTQ2MThhM2JkMTkxZWU5ZjZlMDJkYjM0N2Y0ZTVmYTA0YzEyMzY4ZTg3MTBmY2EyMjgzZWZiIiwiaWF0IjoxNzM2ODY0OTUxLjc2MDQwMiwibmJmIjoxNzM2ODY0OTUxLjc2MDQwNCwiZXhwIjoxNzY4NDAwOTUxLjc1MzQ3NSwic3ViIjoiMjAzOTkxMjEiLCJzY29wZXMiOlsic2hvcHMubWFuYWdlIiwic2hvcHMucmVhZCIsImNhdGFsb2cucmVhZCIsIm9yZGVycy5yZWFkIiwib3JkZXJzLndyaXRlIiwicHJvZHVjdHMucmVhZCIsInByb2R1Y3RzLndyaXRlIiwid2ViaG9va3MucmVhZCIsIndlYmhvb2tzLndyaXRlIiwidXBsb2Fkcy5yZWFkIiwidXBsb2Fkcy53cml0ZSIsInByaW50X3Byb3ZpZGVycy5yZWFkIiwidXNlci5pbmZvIl19.AO6LRFHFHLa4H5RNTyDFX1LAMBhE7v9rY_yhhK5gJSVrclxH-gEJAogNwtpC22tezqVdYAIzTw74SW-9xLE",
    "User-Agent": "MyPrintifyApp",  # Change this to match your app name
    "Content-Type": "application/json"
}

def get_shops():
    """Fetches and lists all connected stores."""
    url = f"https://api.printify.com/v1/shops.json"
    response = requests.get(url, headers=HEADERS)
    
    if response.status_code == 200:
        shops = response.json()
        if shops:
            print("Connected Stores:")
            for shop in shops:
                print(f"ID: {shop['id']}, Title: {shop['title']}")
            return shops
        else:
            print("No stores connected yet.")
    else:
        print(f"Error: {response.status_code}, {response.text}")

if __name__ == "__main__":
    get_shops()

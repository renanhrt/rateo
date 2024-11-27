import requests
import json

params = {
    'grant_type': 'client_credentials',
    'client_id': '2667aa6e88a249108b9a6228d266c4d3',
    'client_secret': '1141d42afb8c4dde8f37ad6b7527157e'
}

url = 'https://accounts.spotify.com/api/token'

response = requests.post(url, data=params).json()

token = response['access_token']

url = 'https://api.spotify.com/v1/search?q=sultans+of+swing&type=track&market=BR&limit=10&include_external=audio'

headers ={
    'Authorization': 'Bearer ' + token
}

response = requests.get(url, headers=headers).json()

with open('response.json', 'w') as outfile:
    json.dump(response, outfile, indent=4)


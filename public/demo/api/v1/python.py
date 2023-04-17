import json
import cgi

# Get the input data from the AJAX request
form = cgi.FieldStorage()
code = form.getvalue('data')

# Evaluate the code
try:
    result = eval(code)
except Exception as e:
    result = str(e)

# Convert the result to a JSON string and return it
print('Content-Type: application/json')
print()
print(json.dumps(result))

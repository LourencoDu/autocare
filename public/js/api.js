function post(url, body) {
  return fetch(`/autocare/api${url}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body
  })
  .then(response => response.json())
}

function get(url) {
  return fetch(`/autocare/api${url}`, {
    method: 'GET'
  })
  .then(response => response.json())
}

function getText(url) {
  return fetch(`/autocare/api${url}`, {
    method: 'GET'
  })
  .then(response => response.text())
}


## Adding a ChatGPT Bot to a Laravel Project 

This guide demonstrates how to integrate OpenAI's ChatGPT bot into a Laravel project using the Guzzle HTTP client.

### Prerequisites
1. Laravel 8 or higher
2. OpenAI API key (Get yours at [OpenAI Signup](https://platform.openai.com/signup))
3. PHP 7.4 or higher
4. Composer installed

---

### Step 1: Obtain an OpenAI API Key
1. Create an account at [OpenAI Platform](https://platform.openai.com/signup).
2. Navigate to the **API Keys** section and generate a new API key.

---

### Step 2: Install Guzzle HTTP Client
1. Install the Guzzle HTTP client by running:
   ```bash
   composer require guzzlehttp/guzzle
   ```

---

### Step 3: Configure Environment Variables
1. Open the `.env` file in your Laravel project directory.
2. Add the following line:
   ```env
   OPENAI_API_KEY=your_openai_api_key
   ```

---

### Step 4: Add the ChatGPT Bot Route
1. Open `routes/web.php` and add this route:
   ```php
   use Illuminate\Http\Request;
   use GuzzleHttp\Client;

   Route::post('/ask-chatbot', function (Request $request) {
       $apiKey = env('OPENAI_API_KEY');

       if (!$apiKey) {
           return response()->json(['error' => 'API key not configured'], 500);
       }

       $client = new Client();
       $response = $client->post('https://api.openai.com/v1/chat/completions', [
           'headers' => [
               'Authorization' => 'Bearer ' . $apiKey,
               'Content-Type'  => 'application/json',
           ],
           'json' => [
               'model' => 'gpt-3.5-turbo',
               'messages' => [
                   ['role' => 'user', 'content' => $request->input('message')],
               ],
           ],
       ]);

       $data = json_decode($response->getBody(), true);

       return response()->json([
           'message' => $data['choices'][0]['message']['content'] ?? 'No response from ChatGPT',
       ]);
   });
   ```

   This route:
   - Sends the user’s message to OpenAI using Guzzle.
   - Returns the ChatGPT response as JSON.

---

### Step 5: Frontend (HTML)
Add an interface for sending messages and displaying responses:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatGPT Bot</title>
</head>
<body>
    <div>
        <h1>ChatGPT Bot</h1>
        <textarea id="userMessage" placeholder="Enter your message..."></textarea>
        <button onclick="sendMessage()">Send</button>
        <div id="botResponse"></div>
    </div>

    <script>
        async function sendMessage() {
            const message = document.getElementById('userMessage').value;
            const responseDiv = document.getElementById('botResponse');

            try {
                const response = await fetch('/ask-chatbot', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                responseDiv.innerHTML = `<p>${data.message}</p>`;
            } catch (error) {
                responseDiv.innerHTML = `<p>Error: ${error.message}</p>`;
            }
        }
    </script>
</body>
</html>
```

---

### Step 6: Test the Integration
1. Start your Laravel development server:
   ```bash
   php artisan serve
   ```
2. Open `http://127.0.0.1:8000` in your browser and interact with the chatbot.

---

### Troubleshooting
- **500 Internal Server Error:** Ensure your `.env` file has the correct OpenAI API key.
- **401 Unauthorized:** Verify that the API key is valid.
- **Guzzle Request Errors:**
  - Double-check the OpenAI endpoint URL (`https://api.openai.com/v1/chat/completions`).
  - Ensure the request JSON structure matches OpenAI’s API documentation.

---

By following these steps, you can integrate ChatGPT into your Laravel project using Guzzle. 🎉


### Check Out My YouTube Channel!  
For more tech-related content and projects, visit my YouTube channel:  
[Kenan Kutluyum](https://www.youtube.com/@KenanKutluyum)  

Don’t forget to subscribe and stay tuned for more updates! 🎥


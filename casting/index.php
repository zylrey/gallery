<h2>Casting</h2>
<p>Gensan Courtesans is currently seeking young, beautiful open-minded girls to join our agency.</p>
<p>Our requirements:</p>
<ul>
    <li>Be 18-30 years old</li>
    <li>Be able to hold a conversation in English.</li>
    <li>Be classy, down to earth and easy to get along with.</li>
    <li>Have valid ID.</li>
    <li>Willing to meet gentlemen of all races.</li>
    <li>Live in Metro Manila.</li>
    <li>Be willing to be posted in our gallery section.</li>
</ul>
<p>If you feel like you meet these requirements and would be a good candidate to join our team, we offer:</p>
<ul>
    <li>A secure working environment. Your safety is our number 1 priority.</li>
    <li>Professional (Female) management who's always there when you need us.</li>
    <li>Flexible schedule.</li>
    <li>A generous stable income.</li>
    <li>College tuition assistance.</li>
    <li>A free gym membership.</li>
    <li>A free photoshoot to help boost your profile on our gallery.</li>
</ul>
<p>Please fill out the form below or email us directly at <a href="mailto:xzylrey12@gmail.com">jensanchezmc@gmail.com</a> to request a call back. Expect a call back within 24 hours.</p>

<!-- CSS Styles -->
<style>

    body {
        background-color: #f4f4f4;
    }

    h2 {
        color: #333;
    }
    form {
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    label {
        display: block;
        margin: 10px 0 5px;
    }
    input[type="text"],
    input[type="number"],
    input[type="tel"],
    input[type="email"],
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    button {
        background-color: #5cb85c;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    button:hover {
        background-color: #4cae4c;
    }
</style>

<form action="submit_form.php" method="post" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    
    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required>
    
    <label for="height">Height:</label>
    <input type="text" id="height" name="height" required>
    
    <label for="weight">Weight:</label>
    <input type="text" id="weight" name="weight" required>
    
    <label for="mobile">Mobile Number:</label>
    <input type="tel" id="mobile" name="mobile" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    
    <label for="photos">Attached your photos:</label>
    <input type="file" id="photos" name="photos[]" multiple required>
    
    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="4"></textarea>
    
    <button type="submit">SEND</button>
</form>
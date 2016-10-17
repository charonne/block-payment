<h1>Presentation</h1>
<p>
    Block Payment is a simple app to make bitcoin payments to a group of people. <strong>It is used as an exercice to understand bitcoin.</strong><br />
    The app can send small amounts of satoshis to a group of people, and check if the users have sent the amount back.
</p>
<p>
    Block Payment is developped with  the wallet service <a href="https://www.block.io/">Block.io</a>, the PHP Framework Laravel, Bootstrap, and SQLite.
</p>


<h1>Installation</h1>
<h2>Install vendors</h2>
<p>
    Execute composer <code>composer update</code>
</p>
<h2>Add block.io credentials</h2>
<p>
Create the file /config/api.php, and add<br />
<code>
return [
    // ... 
    
    // Block.io API
    'blockio' => [
        'apiKey'    => 'xxxx-xxxx-xxxx-xxxx',
        'pin'       => 'xxxxx',
    ],
    // ...   
];
</code>
</p>
<h2>Install database</h2>
<p>
Create the database sqlite file, <code>touch database/database.sqlite</code>
</p>
<p>
To create tables, execute <code>php artisan migrate</code>
</p>

<h1>Usage</h1>
<h2>Create a payment</h2>
<p>
    You have to start a payment, then give the 4 letters code to users.
</p>
<h2>Add an user address</h2>
<p>
    Users have to add the code to add their address.<br />
    For the exercice, users have to use a new bitcoin address that will never be used again, so they can add their private key if their are not sure to remeber it.
</p>
<h2>Make a payment</h2>
<p>
    Use the artisan command <code>php artisan payment:send <i>payment_code</i></code>
</p>
<h2>Check the addresses balance</h2>
<p>
    In the exercice, users have to send the amount back. This script is to check their balance which should be equal to 0.<br />
    Use the artisan command <code>php artisan payment:check <i>payment_code</i></code>
</p>

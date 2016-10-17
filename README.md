<h1>Presentation</h1>
<p>
    Block Payment is a simple app to make bitcoin payments to a group of people. It is used as an exercice to understand bitcoin.<br />
    The app can send small amounts to a group of people, and people have to send the amount back.
</p>
<p>
    Block Payment is developped with <a href="https://www.block.io/">Block.io</a> the wallet services, the PHP Framework Laravel, Bootstrap, and SQLite.
</p>
<h1>Usage</h1>
<h2>Create a payment</h2>
<p>
    You have to start a payment add give the code to users.
</p>
<h2>Add an address</h2>
<p>
    Users have to add the code to get their address.<br />
    For the exercice, users have to use a new bitcoin address that will never be used again, so they can add their private key if their are not sure to remeber it.
</p>
<h2>Make a payment</h2>
<p>
    Use the artisan command <code>php artisan payment:send <i>payment_code</i></code>
</p>
<h2>Check the addresses balance</h2>
<p>
    Use the artisan command <code>php artisan payment:check <i>payment_code</i></code>
</p>

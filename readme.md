<h1>The Assessment is solved as follows</h1>

<p>After cloning the assessment you will do the following:</p>
<ul>
   <li>run composer update</li>
   <li>copy .env.example</li>
   <li>setup database</li>
</ul>

<br>
<p>
I have used Laravel passport as it uses league/oauth2-server. <br>
I created created 3 variables on .env and inside config/services.php I have configured them.
</p>
<h4>Variables</h4>
<ul>
    <li>CLIENT_ID - Passport</li>
    <li>CLIENT_SECRET</li>
    <li>LOGIN_END_POINT</li>
</ul>
<p>
When you run php artisan passport:install it generate two oauths.
<br>
Laravel Personal Access Client
<br>
Laravel Password Grant Client
<br>

They have client id and client secret and we are interested on password grant client

</p>
<br>
<p>
In order for the solution to be implemented, I have created two migrations.
</p>
<ul>
    <li>Projects</li>
    <li>Tasks</li>
</ul>
<p>
There are two  seeds for adding a user, projects and tasks.
The seeds gives us the starting point.
</p>

<h2>Laravel PHPUnit Tests</h2>
<p>I have created create three units test with their methods</p>
<ul>
    <li>AuthenticationTest</li>
    <li>Project</li>
    <li>Task</li>
</ul>
<p>
To test the functionality, you'll need either POSTMAN or Insomia
</p>

<h6>Things that I didn't do and why</h6>
<p>I didn't use Symfony as I am still new to it and the resources of Symfony requires payment</p>
<p>I didn't use docker as I still have to learn it</p>
<p>I didn't use Postgres DB</p>


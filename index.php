<?php 
// Main page

// HTML header
include('includes/header.html');
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h3>Message Board Application</h3>
            <hr>
            <p>Application powered by PHP and MySQL for backend operations with Bootstrap for styling. This is a basic practice application that allows you to create posts or forums and even create some of your own. 
                Since this is a practice project, I already have you logged in as a user already in my MySQL Database (Trouster with User ID 1). Originally created the database using a local storage via phpMyAdmin 
                and then moved the data to a remote Heroku ClearDB. I also used MySQL Workbench when attempting to connect with ClearDB but ended up going back to phpMyAdmin out of preference. Sessions used throughout 
                the use of the app to keep track of user login and time zone information. 
            </p>

            <p>Multiple languages can be selected and contributed to if you're familiar and your keyboard is capable. I didn't include translations for descriptions of project functionality since I will mostly be 
                presenting this to English speaking employers/recruiter although changing the language does change the language of links and information presented.
            </p>
        </div>
    </div>
</div>


<?php

// HTML footer
include('includes/footer.html');
?>
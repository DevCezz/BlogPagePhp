<?php
    session_start();

    require('inc/header.inc.php');
    require('inc/menu.inc.php');

    require_once('logic/userManager.inc.php');

    try {
        $userManager = new UserManager();
        $posts = $userManager->getAllPosts();
    } catch (Exception $exception) {
        $errorMessage = "Wystąpił wewnętrzny błąd serwera. Przepraszamy.<br>Informacja o błędzie: " . $exception->getMessage();
    }
?>

<div class="ui main text container">
    <h1 class="ui header textCenter">Posty</h1>

    <div class="ui top attached segment">
        <div class="ui divided items">
            <% blogs.forEach((blog) => { %>
                <div class="item">
                    <div class="image">
                        <img src="<%= blog.image %>" alt="No image">
                    </div>
                    <div class="content">
                        <a class="header" href="/blogs/<%= blog._id %>"><%= blog.title %></a>
                        <div class="met">
                            <span><%= blog.created.toDateString() %></span>
                        </div>
                        <div class="description">
                            <p><%- blog.body.substring(0, 100) %>...</p>
                        </div>
                        <div class="extra">
                            <a class="ui floated basic violet button" href="/blogs/<%= blog._id %>">Read More <i class="right chevron icon"></i></a>
                        </div>
                    </div>
                </div>
            <% }); %>
        </div>
    </div>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>
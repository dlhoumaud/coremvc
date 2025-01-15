function () {
<?php if ($hover) { ?>
    console.log("hover <?= $user['id'] ?> : <?= $user['firstname'] ?> <?= $user['lastname'] ?>");
<?php } else if ($hoverOut) { ?>
    console.log("hoverOut <?= $user['id'] ?> : <?= $user['firstname'] ?> <?= $user['lastname'] ?>");
<?php } else { ?>
    sendRequest({
        url: "<?= getenv('APP_URL') ?>/api/user/<?= $user['id'] ?>/articles",
        method: "GET",
        callback: (error, response) => {
            if (error) {
                console.error("Erreur:", error, response);
            } else {
                if (response.error === undefined) {
                    $("#content_title").html(response[0].title);
                    $("#content").html(response[0].contents);
                    let articles='';
                    response.forEach(article => {
                        articles +=`
                            <article>
                            <h2>${article.title}</h2>
                            <h4 class='text-muted'>${article.description}</h4>
                            <p>${article.contents}</p>
                            </article>
                        `;
                    });
                    $("#content").html(articles);
    
                    console.log(response);
                } else {
                    console.error(response.error);
                }
            }
        }
    });
<?php } ?>
}
function () {
<?php if ($hover) { ?>
    console.log("hover <?= $user['id'] ?> : <?= $user['firstname'] ?> <?= $user['lastname'] ?>");
<?php } else if ($hoverOut) { ?>
    console.log("hoverOut <?= $user['id'] ?> : <?= $user['firstname'] ?> <?= $user['lastname'] ?>");
<?php } else { ?>
    alert("click <?= $user['id'] ?> : <?= $user['firstname'] ?> <?= $user['lastname'] ?>");
<?php } ?>
}
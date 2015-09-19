<h1>Upload Image</h1>

<span class="take-user-primary-photo">PHOTO UPLOAD...</span>
<div class="user-primary-photo">
    <?php
    $photo = login()->getPrimaryPhoto();
    if ( $photo ) {
        $url = $photo->urlThumbnail(140, 140);
        echo "<img src='$url'>";
    }
    ?>
</div>

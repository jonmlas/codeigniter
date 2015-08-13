<h2><?php echo $title ?></h2>

<?php foreach ($news as $news_item): ?>

        <div class="main">
                <?php echo 'Supplier Cost: '.$news_item['Supplier Cost']; ?>
        </div>
        <p><!--<a href="<?php //echo $news_item['Selling Price']; ?>">View article</a>-->
	
<?php $image = base64_encode($news_item['myphoto']);  ?>
<img src='data:image/jpg;charset=utf8;base64,<?php echo $image; ?>' />

</p>
<?php endforeach ?>
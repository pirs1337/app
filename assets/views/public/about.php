<? 
    require_once '../../includes/include.php';
    $title = 'О нас';
    require_once '../layouts/head.php'; 
?>
    <main class="container">
        <h1 class="text-white"><? echo $title ?></h1>
        
        <div class="clearfix text-white">
            <p>
                A paragraph of placeholder text. We're using it here to show the use of the clearfix class. We're adding quite a few meaningless phrases here to demonstrate how the columns interact here with the floated image.
            </p>

            <p>
                As you can see the paragraphs gracefully wrap around the floated image. Now imagine how this would look with some actual content in here, rather than just this boring placeholder text that goes on and on, but actually conveys no tangible information at. It simply takes up space and should not really be read.
            </p>

            <p>
                And yet, here you are, still persevering in reading this placeholder text, hoping for some more insights, or some hidden easter egg of content. A joke, perhaps. Unfortunately, there's none of that here.
            </p>
        </div>
    </main>
    <? require_once '../layouts/footer.php'; ?>
</body>
</html>
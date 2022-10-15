        </main>
    </div>
</div>
<footer class="site-footer">
    <div class="container">
        &copy; MVC site
    </div>
</footer>

<?php

/**
 * @var stdClass $userInfo
 */

if ($userInfo->canUser('terminal')) :
    include "template/terminalModal.php";
?>
<!--    <script src="assets/js/scripts/modules/model.js"></script>-->
<?php endif;?>

</body>
</html>
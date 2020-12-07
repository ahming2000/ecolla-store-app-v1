<nav>
    <ul class="pagination justify-content-center">
        <li class="page-item <?php echo $page == 1 ? "disabled" : ""; ?>">
            <a class="page-link" href="<?= $pageName . "?page=" . $previousPage; ?>" id="previous-button" <?php echo $page == 1 ? "tabindex='1' aria-disabled='true'" : ""; ?>>上一页</a>
        </li>
        <?php for($i = 1; $i <= $totalPage; $i++) : ?>
            <li class="page-item <?php echo $page == $i ? "active" : ""; ?>"><a class="page-link" href="<?= $pageName . "?page=" . $i; ?>"><?= $i; ?></a></li>
        <?php endfor; ?>
        <li class="page-item<?php echo $page == $totalPage ? " disabled" : ""; ?>">
            <a class="page-link" href="<?= $pageName . "?page=" . $nextPage; ?>" id="next-button" <?php echo $page == $totalPage ? "tabindex='1' aria-disabled='true'" : ""; ?>>下一页</a>
        </li>
    </ul>
</nav>

<script>

</script>

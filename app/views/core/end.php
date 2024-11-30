        <cookies-consent></cookies-consent>
        <script>
            window.vueDatas = <?= !empty($vue_datas)?json_encode($vue_datas):'{}'; ?>;
            window.vueMethods = <?= !empty($vue_methods)?json_encode($vue_methods):'{}'; ?>;
            window.vueComponents = <?= json_encode($vue_components??''); ?>;
        </script>
        <script type="text/javascript"><?php include_once 'js/app.min.js'; ?></script>
    </body>
</html>
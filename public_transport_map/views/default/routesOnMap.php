
<?php
echo "<script>
    var nodeNameArr =".$nodeNameArr.";
    var nodeLatArr =".$nodeLatArr.";
    var nodeLngArr =".$nodeLngArr.";

    $(function () {
        start(nodeNameArr, nodeLatArr, nodeLngArr);
    })
</script>";

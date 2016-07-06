<?php
humhub\modules\public_transport_map\Assets::register($this);

/**
 * Main view.
 */
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.js"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong><?= Yii::t('PublicTransportMapModule.views_default_index', 'Transport map') ?></strong>
                </div>
                <hr>
                <div class="panel-body">
                    <div id="tabs">
                        <ul class='nav nav-justified nav-tabs' data-tabs='tabs'>
                            <?php
                            /**
                             * Drawing tabs.
                             */
                                $current_date = new DateTime(date('d.m'));
                                for ($i = 0; $i < 8; $i++)
                                {
                                    echo "<li>";
                                        echo "<a href=".($current_date->format('Y-m-d'))." data-toggle='tab'>";
                                            echo Yii::t('PublicTransportMapModule.views_default_index', ($current_date->format('l')));
                                            echo "<span style='display: block; color: #716f6f;'>".($current_date->format('d.m'))."</span>";
                                        echo "</a>";
                                    echo "</li>";
                                    $current_date->modify('+1 day');
                                }
                                $current_date->modify('-8 days');
                            ?>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active">
                            <form>
                                <select id="routes" class="form-control">
                                </select>
                            </form>
                        </div>
                    </div>
                    
                    <?php
                    echo $this->render('nodes', array(
                        'nodes'=>$nodes,
                        'schedule'=>$schedule,
                        'id'=>$id,
                        'routeNode'=>$routeNode,
                        'nodeNameArr'=>$nodeNameArr,
                        'nodeLatArr'=>$nodeLatArr,
                        'nodeLngArr'=>$nodeLngArr
                    ));
                    echo $this->render('mapCreate');
                    ?>

                    <script>
                        /**
                         * Actions performed on page load.
                         */
                        $( document ).ready(function()
                        {
                            $('.nav-tabs a[href="<?php echo($current_date->format('Y-m-d')); ?>"]').tab('show');
                        });

                        /**
                         * Refilling dropdown list on tab change.
                         */
                        $("#tabs").on('shown.bs.tab', function(event)
                        {
                            $('#routes').empty();
                            $.ajax({
                                type: 'POST',
                                url: 'index.php?r=public_transport_map%2Fdefault%2Flist-generator&date=' + $('.nav-tabs .active a').attr('href'),
                                success: function (data) {
                                    var parsedJSON = JSON.parse(data);
                                    $.each(parsedJSON[0], function(i) {
                                        $('#routes').append($("<option></option>").attr("value", i).text(parsedJSON[1][i]+': '+parsedJSON[0][i]));
                                    })
                                }
                            });
                            $('.tab-pane select').trigger('change', '0');
                            $('#nodes .btn-primary').trigger('onclick', '0');
                        });

                        /**
                         * Redrawing route on tab change.
                         */
                        $('.tab-pane select').on('change', function ()
                        {
                            var id = $('#routes').val();
                            showNodes(id);
                        });
                        function showNodes(str)
                        {
                            if (str == "")
                            {
                                document.getElementById("nodes").innerHTML = "";
                                return;
                            } else
                            {
                                if (window.XMLHttpRequest)
                                {
                                    // code for IE7+, Firefox, Chrome, Opera, Safari
                                    xmlhttp = new XMLHttpRequest();
                                } else {
                                    // code for IE6, IE5
                                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                                }
                                xmlhttp.onreadystatechange = function()
                                {
                                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                                    {
                                        document.getElementById("nodes").innerHTML = xmlhttp.responseText;
                                    }
                                };
                                xmlhttp.open("GET","index.php?r=public_transport_map%2Fdefault%2Fnodes-collection&id="+str,true);
                                xmlhttp.send();
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
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
                            $typeOfDay = null;
                            $current_date = new DateTime(date('d.m'));
                            for ($i = 0; $i < 7; $i++)
                            {
                                if ($current_date->format('D') != 'Sun' && $current_date->format('D') != 'Sat')//it checks all the days for weekend/workdays
                                {
                                    $typeOfDay[$i] = 1;
                                }
                                else
                                {
                                    $typeOfDay[$i] = 0;
                                }
                                echo "<li>";
                                    echo "<a href=".($current_date->format('Y-m-d'))." data-toggle='tab' typeOfSelectedDay=".($typeOfDay[$i]).">";
                                        echo Yii::t('PublicTransportMapModule.views_default_index', ($current_date->format('l')));
                                        echo "<span style='display: block; color: #716f6f;'>".($current_date->format('d.m'))."</span>";
                                        echo "<span style='display: block; color: #716f6f;'>".($typeOfDay[$i])."</span>";
                                    echo "</a>";
                                echo "</li>";
                                $current_date->modify('+1 day');
                            }
                            $current_date->modify('-7 days');
                            $typeOfCurrentDay = 0;//counts just current day. when user switches tab it not changes
                            if ($current_date->format('D') != 'Sun' && $current_date->format('D') != 'Sat') $typeOfCurrentDay = 1;
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

                    echo "<a href='index.php?r=public_transport_map%2Fdefault%2Fadmin-panel'>Go to admin panel</a>"

                    ?>

                    <script>
                        /**
                         * Actions performed on page load.
                         */

                        var clickFlagForJsonRequests = 0;

                        $( document ).ready(function()
                        {
                            $('.nav-tabs a[href="<?php echo($current_date->format('Y-m-d')); ?>"]').tab('show');
                        });

                        /**
                         * Refilling dropdown list on tab change.
                         */
                        $("#tabs").on('shown.bs.tab', function(event)
                        {
                            //дописать чтоб при перевыборе вкладки менялся и id, который передается в showNodes
                            $('#routes').empty();
                            $.ajax({
                                type: 'POST',
                                url: 'index.php?r=public_transport_map%2Fdefault%2Flist-generator&date=' + $('.nav-tabs .active a').attr('href'),
                                success: function (data) {
                                    var parsedJSON = JSON.parse(data);
                                    //alert(parsedJSON);
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
                            clickFlagForJsonRequests++;
                            if (clickFlagForJsonRequests < 2) {
                                //alert('select was changed');
                                var id = $('#routes').val();
                                showNodes(id, true);
                            }
                            else {
                                var id = $('#routes').val();
                                showNodes(id, false)
                            }
                        });
                        function showNodes(str, firstCall)
                        {
                            if (str === null) str = '0';
                            //alert(str + ' ' + firstCall);
                            //alert('shownodes was called');
                            if (str == "")
                            {
                                //alert('select is empty');
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
                                if (firstCall) {
                                    //alert('firstCall');
                                    xmlhttp.open("GET","index.php?r=public_transport_map%2Fdefault%2Fnodes-collection&id=" + str + '&current_date=' + $('.nav-tabs .active a').attr('href'),true);
                                    xmlhttp.send();
                                }
                                else {
                                    //alert('notFirst');// alert(str);
                                    //отрисовка табличек с названиями остановок
                                    xmlhttp.open("GET","index.php?r=public_transport_map%2Fdefault%2Fnodes-collection&id=" + str + '&current_date=' + $('.nav-tabs .active a').attr('href'),true);
                                    xmlhttp.send();


                                    //запрс для получения информации и последующей отрисовки карты
                                    $.ajax({
                                        type: 'POST',
                                        url: 'index.php?r=public_transport_map%2Fdefault%2Froute-refresh&id=' + str + '&current_date=' + $('.nav-tabs .active a').attr('href'),
                                        success: function (data) {
                                            //получаем всю информацию о точках чтоб поставить их на карту
                                            var parsedJSON = JSON.parse(data);
                                            //alert(parsedJSON[1][1] + ' ' + parsedJSON[2][1]);
                                            //здесь надо написать функцию по установке точек и прокладке маршрута
                                            start(parsedJSON[0], parsedJSON[1], parsedJSON[2])
                                        },
                                        error: function () {
                                            alert('error in map ajax request')
                                        }
                                    });
                                    //alert('request was sent');
                                }
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
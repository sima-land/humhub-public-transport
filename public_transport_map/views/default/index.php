<?php
humhub\modules\public_transport_map\Assets::register($this);
use \humhub\modules\public_transport_map\controllers\DefaultController;
use yii\helpers\Html;
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Yii::t('PublicTransportMapModule.views_default_index', 'Transport map') ?>
                </div>
                <hr>

                <div class="panel-body">
                    <ul class='nav nav-justified nav-tabs' data-tabs='tabs'>
                        <?php
                            $current_date = new DateTime(date('d.m'));

                            for ($i = 0; $i < 8; $i++)
                            {
                                echo "<li>";
                                    echo "<a href=".$i." data-toggle='tab'>";
                                        echo Yii::t('PublicTransportMapModule.views_default_index', ($current_date->format('l')));
                                        echo "<span style='display: block; color: #716f6f;'>".($current_date->format('d.m'))."</span>";
                                    echo "</a>";
                                echo "</li>";
                                $current_date->modify('+1 day');
                            }
                            $current_date->modify('-8 days');
                        ?>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active">
                            <select id="routes" class="form-control">
                            </select>
                        </div>
                    </div>

                    <script>
                        $( document ).ready(function()
                        {
                            $('.nav-tabs a[href="<?=($current_date->format('Y-m-d')); ?>"]').tab('show');
                        });

                        $("#tabs").on('shown.bs.tab', function(event)
                        {
                            $('#routes').empty();

                            $.ajax({
                                type: 'POST',
                                url: 'index.php?r=public_transport_map%2Fdefault%2Flist-generator&date=' + $('.nav-tabs .active a').attr('href'),
                                success: function (data) {
                                    var parsedJSON = JSON.parse(data);
                                    $.each(parsedJSON[0], function(i) {
                                        $('#routes').append($("<option></option>").attr("value", i).text(parsedJSON[0][i]));
                                    });
                                }
                            });
                        });

                        $('.tab-pane select').on('change', function ()
                        {
                            var id = $('#routes').val();
                            console.log('yay!'+id);
                            $.ajax({
                             type: 'POST',
                             url: 'index.php?r=public_transport_map%2Fdefault%2Fnodes-collecton&id=' + id,
                             success: function () {}
                             });
                        });
                    </script>

                    <div id="map" class="map"></div>
                    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
                    <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.0.3/leaflet-routing-machine.js"></script>


                    <script>
                        $('.nav-tabs a[href="0"]').tab('show');
                    </script>



                </div>
            </div>
        </div>
    </div>
</div>

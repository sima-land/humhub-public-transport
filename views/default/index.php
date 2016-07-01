<?php
humhub\modules\public_transport_map\Assets::register($this);
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo Yii::t('PublicTransportMapModule.views_default_index', 'Transport map') ?>
                </div>
                <hr>
                
                <div class="panel-body">
                    <script>
                        /**
                         * Drawing dynamic tabs.
                         *
                         * The following script generates dynamic tabs with names and dates for today and the week ahead).
                         * It uses standard functions and arrays to store generated data.
                         */
                        function getDayName(dayNumber)
                        {
                            switch (dayNumber)
                            {
                                case 0: return "Sunday";
                                case 1: return "Monday";
                                case 2: return "Tuesday";
                                case 3: return "Wednesday";
                                case 4: return "Thursday";
                                case 5: return "Friday";
                                case 6: return "Saturday";
                            }
                        }
                        function getMonthName(monthNumber)
                        {
                            switch (monthNumber)
                            {
                                case 0: return "January";
                                case 1: return "February";
                                case 2: return "March";
                                case 3: return "April";
                                case 4: return "May";
                                case 5: return "June";
                                case 6: return "July";
                                case 7: return "August";
                                case 8: return "September";
                                case 9: return "October";
                                case 10: return "November";
                                case 11: return "December";
                            }
                        }

                        var now, day, date, month;
                        var dates = [];
                        var days = [];
                        var months = [];

                        now = new Date();
                        day = now.getDay();
                        month = now.getMonth();

                        dates[0] = now.getDate();
                        days[0] = getDayName(now.getDay());
                        months[0] = now.getMonth();
                        
                        for (var i = 1; i < 8; i++)
                        {
                            dates[i] = new Date(new Date().getTime() + ((24 * 60 * 60 * 1000) * i)).getDate();
                            days[i] = getDayName(new Date(new Date().getTime() + ((24 * 60 * 60 * 1000) * i)).getDay());
                            months[i] = new Date(new Date().getTime() + ((24 * 60 * 60 * 1000) * i)).getMonth()
                        }
                        
                        document.write("<ul id='days' class='nav nav-justified nav-tabs' data-tabs='tabs'>");
                        document.write("    <li>");
                        document.write("        <a href='#today' data-toggle='tab'>");
                        document.write("            <?php echo Yii::t('PublicTransportMapModule.views_default_index', 'Today') ?>");
                        document.write("            <span style='display: block; color: #716f6f;'>");
                        document.write(                getMonthName(months[0])+" "+dates[0]);
                        document.write("            </span>");
                        document.write("        </a>");
                        document.write("    </li>");
                        document.write("    <li>");
                        document.write("        <a href='#tomorrow' data-toggle='tab'>");
                        document.write("            <?php echo Yii::t('PublicTransportMapModule.views_default_index', 'Tomorrow') ?>");
                        document.write("            <span style='display: block; color: #716f6f;'>");
                        document.write(                 getMonthName(months[1])+" "+dates[1]);
                        document.write("            </span>");
                        document.write("        </a>");
                        document.write("    </li>");
                        document.write("    <li>");
                        document.write("        <a href='#2days' data-toggle='tab'>");
                        document.write(             days[2]);
                        document.write("            <span style='display: block; color: #716f6f;'>");
                        document.write(                 getMonthName(months[2])+" "+dates[2]);
                        document.write("            </span>");
                        document.write("        </a>");
                        document.write("    </li>");
                        document.write("    <li>");
                        document.write("        <a href='#3days' data-toggle='tab'>");
                        document.write(             days[3]);
                        document.write("            <span style='display: block; color: #716f6f;'>");
                        document.write(                 getMonthName(months[3])+" "+dates[3]);
                        document.write("            </span>");
                        document.write("        </a>");
                        document.write("    </li>");
                        document.write("    <li>");
                        document.write("        <a href='#4days' data-toggle='tab'>");
                        document.write(             days[4]);
                        document.write("            <span style='display: block; color: #716f6f;'>");
                        document.write(                 getMonthName(months[4])+" "+dates[4]);
                        document.write("            </span>");
                        document.write("        </a>");
                        document.write("    </li>");
                        document.write("    <li>");
                        document.write("        <a href='#5days' data-toggle='tab'>");
                        document.write(             days[5]);
                        document.write("            <span style='display: block; color: #716f6f;'>");
                        document.write(                 getMonthName(months[5])+" "+dates[5]);
                        document.write("            </span>");
                        document.write("        </a>");
                        document.write("    </li>");
                        document.write("    <li>");
                        document.write("        <a href='#6days' data-toggle='tab'>");
                        document.write(             days[6]);
                        document.write("            <span style='display: block; color: #716f6f;'>");
                        document.write(                 getMonthName(months[6])+" "+dates[6]);
                        document.write("            </span>");
                        document.write("        </a>");
                        document.write("    </li>");
                        document.write("    <li>");
                        document.write("        <a href='#7days' data-toggle='tab'>");
                        document.write(             days[7]);
                        document.write("            <span style='display: block; color: #716f6f;'>");
                        document.write(                 getMonthName(months[7])+" "+dates[7]);
                        document.write("            </span>");
                        document.write("        </a>");
                        document.write("    </li>");
                        document.write("</ul>");
                    </script>
                    
                    <div class="tab-content">
                        <div class="tab-pane" id="today">
                            <select id ="" class="form-control" onchange="start(this.value)">
                            </select>
                        </div>
                        <div class="tab-pane" id="tomorrow">
                            <select class="form-control" onchange="start(this.value)">
                            </select>
                        </div>
                        <div class="tab-pane" id="2days">
                            <select class="form-control" onchange="start(this.value)">
                            </select>
                        </div>
                        <div class="tab-pane" id="3days">
                            <select class="form-control" onchange="start(this.value)">
                            </select>
                        </div>
                        <div class="tab-pane" id="4days">
                            <select class="form-control" onchange="start(this.value)">
                            </select>
                        </div>
                        <div class="tab-pane" id="5days">
                            <select class="form-control" onchange="start(this.value)">
                            </select>
                        </div>
                        <div class="tab-pane" id="6days">
                            <select class="form-control" onchange="start(this.value)">
                            </select>
                        </div>
                        <div class="tab-pane" id="7days">
                            <select class="form-control" onchange="start(this.value)">
                            </select>
                        </div>
                    </div>
                    
                    <script>
                         $('.nav-tabs a[href="#today"]').tab('show'); 
                    </script>
                    
                    <div id="map" class="map"></div>
                    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
                    <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
                </div>
            </div>
        </div>
    </div>
</div>

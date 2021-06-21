<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 */

get_header();
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.sightmap.com/v1/assets/1273/multifamily/units',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'API-Key: 7d64ca3869544c469c3e7a586921ba37'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

date_default_timezone_set('UTC');

$units = json_decode($response);
$areaone = [];
$areaplusone = [];

if (! empty($units)) {
    foreach ($units->data as $unit) {
        if ($unit->area === 1) {
            # push this entry into the object
            array_push($areaone, (object)[
              'unit_number' => $unit->unit_number,
              'area'  => $unit->area,
              'updated_at'  => date("F j, Y, g:i a", strtotime($unit->updated_at)),
            ]);
        } else {
            array_push($areaplusone, (object)[
            'unit_number' => $unit->unit_number,
            'area'  => $unit->area,
            'updated_at'  => date("F j, Y, g:i a", strtotime($unit->updated_at)),
          ]);
        }
    }
}

?>



<div class="wrapper">
    <div class="main-panel">
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-body">
                <div class="table-responsive">
                  <div class="card-header">
                    <h4 class="card-title">Area Value of 1</h4>
                  </div>
                  <table class="table tablesorter " id="">
                    <thead class=" text-primary">
                      <tr>
                        <th>
                          Unit Number
                        </th>
                        <th>
                          Area
                        </th>
                        <th>
                          Updated Date
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      
                        <?php
                    foreach ($areaone as $one) {
                        echo '<tr>';
                        echo '<td>' . $one->unit_number . '</td>';
                        echo '<td>' . $one->area . '</td>';
                        echo '<td>' . $one->updated_at . '</td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                  </table>
                  <div class="card-header">
                    <h4 class="card-title">Area Value greater than 1</h4>
                  </div>
                  <table class="table" id="">
                    <thead class=" text-primary">
                      <tr>
                        <th>
                          Unit Number
                        </th>
                        <th>
                          Area
                        </th>
                        <th>
                          Updated Date
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      
                        <?php
                    foreach ($areaplusone as $one) {
                        echo '<tr>';
                        echo '<td>' . $one->unit_number . '</td>';
                        echo '<td>' . $one->area . '</td>';
                        echo '<td>' . $one->updated_at . '</td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

<?php
get_footer();

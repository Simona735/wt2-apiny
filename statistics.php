
<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Richterova">

    <title>Mashup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>
<body>
<header class="p-2 bg-dark text-white ">
    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="index.php" class="nav-link px-4 text-white">Weather</a></li>
        <li><a href="info.php" class="nav-link px-4 text-white">My info</a></li>
        <li><a href="#" class="nav-link px-4  text-warning">Statistics</a></li>
    </ul>
</header>
<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="acceptModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Udeľte súhlas so spracovaním IP adresy a GPS súradníc. Inak nebude sprístupnený obsah stránky.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Accept</button>
                </div>
            </div>
        </div>
    </div>

    <main>
        <div class="row mt-1 g-5 justify-content-center">
            <div class="col-md-6">
                <table id="statesTable" class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="row">Flag</th>
                        <th scope="row">Code</th>
                        <th scope="row">State</th>
                        <th scope="row">Count</th>
                    </tr>
                    </thead>
                    <tbody id="statesBody">
                    </tbody>
                </table>

                <div class="my-5" id="map"></div>


                <table class="table">
                    <thead>
                    <tr>
                        <th colspan="2" class="text-center" scope="row">Subpages visits count</th>
                    </tr>
                    </thead>
                    <tbody id="pagesVisitsBody">
                    </tbody>
                </table>

                <table class="table">
                    <thead>
                    <tr>
                        <th colspan="2" class="text-center" scope="row">Time intervals</th>
                    </tr>
                    </thead>
                    <tbody id="intervalsBody">
                    </tbody>
                </table>

                <!-- Modal -->
                <div class="modal fade" id="stateDetail" tabindex="-1" aria-labelledby="stateDetailLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="stateDetailLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr class="table-active">
                                            <th scope="col">City</th>
                                            <th scope="col">Count</th>
                                        </tr>
                                        </thead>
                                        <tbody id="modalTableBody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </main>


    <footer class="my-3 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy;2021 WEBTECH2 - Richterová </p>
    </footer>
</div>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvv2YY4VLsiEFPJ-pPzru_tfIWMKQmS-I&callback=initMap&libraries=&v=weekly" async ></script>

<script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="js/helpers.js"></script>
<script src="js/javascript.js"></script>
<script src="js/googleMap.js"></script>
</body>
</html>

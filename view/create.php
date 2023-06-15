<?php
include("../global/variables.php");
include(__ROOT . '/includes/head.php');
include(__ROOT . '/includes/css.php');
require(__ROOT . "/includes/loader.php");
include(__ROOT . '/includes/script.php');

?>

<body>
    <div id="main-wrapper">
        <?php
        include(__ROOT . '/includes/topbar.php');
        ?>
        <div class="content-body ml-0">
            <!-- Start content -->
            <div>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="card m-b-20">
                                <div class="card-body" style="padding:50px">

                                    <form action="" id="add_form" name="add_form" method="post" class="form form-horizontal" enctype="multipart/form-data">
                                        <div class="form-row pb-2">
                                            <input name="method" type="hidden" value="search" class="form-control " />
                                            <div class="col d-inline-flex">
                                                <label class="my-auto" for="address">Address:</label>
                                                <input name="address" id="address" type="text" value="" class="form-control " />
                                            </div>
                                            <div class="col d-inline-flex">
                                                <label class="my-auto" for="city">City:</label>
                                                <input name="city" id="city" type="text" value="" class="form-control " />
                                            </div>
                                            <div class="col d-inline-flex">
                                                <label class="my-auto" for="State">State: </label>
                                                <input name="state" id="state" type="text" value="" class="form-control " />
                                            </div>
                                            <div class="col d-inline-flex">
                                                <label class="my-auto" for="zipcode">Zip Code: </label>
                                                <input name="zipcode" id="zipcode" type="text" value="" class="form-control " />
                                            </div>
                                            <div class="col d-inline-flex">
                                                <label class="my-auto" for="county">County: </label>
                                                <input name="county" id="county" type="text" value="" class="form-control " />
                                            </div>
                                        </div>
                                        <div class="form-row pb-2">
                                            <div class="col d-inline-flex">
                                                <label class="my-auto" for="name">Name: </label>
                                                <input name="name" id="name" type="text" value="" class="form-control " />
                                            </div>
                                            <div class="col d-inline-flex">
                                                <label class="my-auto" for="phone_number">Phone Number: </label>
                                                <input name="phone_number" id="phone_number" type="text" value="" class="form-control " />
                                            </div>
                                            <div class="col d-inline-flex">
                                                <label class="my-auto" for="income">Income:</label>
                                                <input name="income" id="income" type="text" value="" class="form-control " />
                                            </div>
                                            <div class="col d-inline-flex">
                                                <label class="my-auto" for="home_value">Home Value:</label>
                                                <input name="home_value" id="home_value" type="text" value="" class="form-control " />
                                            </div>
                                            <div class="col d-inline-flex">
                                                <label class="my-auto" for="name">Age: </label>
                                                <input name="age" id="age" type="text" value="" class="form-control " />
                                            </div>

                                        </div>


                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <button class="btn btn-primary btn-lg waves-effect waves-light" type="submit" name="submit" style="position: absolute; right: 0;">Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card m-b-20 d-none" id="res">
                                <div class="card-body" style="padding:50px">
                                    <div id="export_block" class="btn-block " style="padding: 10px;">
                                        <a id="action" href="#" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-download"></i> Export CSV</a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table responsive mb-20" id="example" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#ID</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Address</th>
                                                    <th scope="col">City</th>
                                                    <th scope="col">State</th>
                                                    <th scope="col">Zip Code</th>
                                                    <th scope="col">County</th>
                                                    <th scope="col">Phone Number</th>
                                                    <th scope="col">Income</th>
                                                    <th scope="col">Home Value</th>
                                                    <th scope="col">Age</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php include(__ROOT . '/includes/footer.php'); ?>
            </div>
        </div>
        <script>
            var mData = [];

            $("#add_form").submit(function(e) {
                mData = [];
                e.preventDefault(); // avoid to execute the actual submit of the form.
                showLoadingBar();
                var form = $(this);

                $.ajax({
                    type: "POST",
                    url: $host + '/controller/customers.php',
                    data: form.serialize(), // serializes the form's elements.
                    dataType: "json",
                    success: function(data) {

                        if (data.result === 'success') {

                            hideLoadingBar();
                            $("#res").removeClass("d-none")
                            let tbody = "";
                            var res = data.data;
                            mData = data.data;
                            for (let x in res) {

                                tbody += '<tr>';
                                tbody += `<td>${res[x].id}</td>`;
                                tbody += `<td>${res[x].name}</td>`;
                                tbody += `<td>${res[x].address}</td>`;
                                tbody += `<td>${res[x].city}</td>`;
                                tbody += `<td>${res[x].state}</td>`;
                                tbody += `<td>${res[x].zipcode}</td>`;
                                tbody += `<td>${res[x].country}</td>`;
                                tbody += `<td>${res[x].phone_number}</td>`;
                                tbody += `<td>${res[x].income}</td>`;
                                tbody += `<td>${res[x].home_value}</td>`;
                                tbody += `<td>${res[x].age}</td>`;
                                tbody += '</tr>';
                            }

                            $("table.table tbody").html(tbody)
                        }
                    }
                });
            });

            const download = function(data) {

                // Creating a Blob for having a csv file format 
                // and passing the data with type
                const blob = new Blob([data], {
                    type: 'text/csv'
                });

                // Creating an object for downloading url
                const url = window.URL.createObjectURL(blob)

                // Creating an anchor(a) tag of HTML
                const a = document.createElement('a')

                // Passing the blob downloading url 
                a.setAttribute('href', url)

                // Setting the anchor tag attribute for downloading
                // and passing the download file name
                a.setAttribute('download', 'download.csv');

                // Performing a download with click
                a.click()
            }

            const uploadCSV = function(data) {

                $.ajax({
                    type: "POST",
                    url: $host + '/controller/customers.php',
                    data: {
                        data: data,
                        method: 'uploadCSV'
                    }, 
                    dataType: "json",
                    success: function(data) {

                        if (data.result === true) {
                           alert(`CSV is uploaded successfully on AWS S3. Path : ${data.s3Link}`);
                            
                        }
                    }
                });
            }

            const get = async function() {
                const replacer = (key, value) => value === null ? '' : value // specify how you want to handle null values here
                const header = Object.keys(mData[0])
                const csv = [
                    header.join(','), // header row first
                    ...mData.map(row => header.map(fieldName => JSON.stringify(row[fieldName], replacer)).join(','))
                ].join('\r\n')

                uploadCSV(csv);

                download(csv);
                
            }

            // Getting element by id and adding
            // eventlistener to listen everytime
            // button get pressed
            const btn = document.getElementById('action');
            btn.addEventListener('click', get);
        </script>
        <?php include(__ROOT . '/includes/script-bottom.php'); ?>
</body>

</html>
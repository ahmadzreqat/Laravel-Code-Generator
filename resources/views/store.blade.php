<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">


<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>


<div class="app-content content  mt-5 px-5">
    <div class="content-overlay"></div>
    <div class="content-wrapper">

        <section id="dom">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Welcome ! , You Can Generate Your Code By Type The Name Of Your Table
                                And Passing Table Fields (Columns)</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">
                                <div class="alert alert-warning">
                                    <b>Note ! :</b>
                                    <div> Dont Pass The "ID" It Will Be Generate Automatically</div>
                                </div>


                                @include('gen::inc.error')
                                @include('gen::inc.success')

                                <form class="form" method="post" action="{{route('gen.post')}}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <h4 class="form-section"><i class="ft-data"></i> Generates</h4>

                                    <div class="form-body">
                                        <div class="row">
                                            <div class="form-group col-md-6 mb-2">
                                                <label for="table">Table Name:

                                                </label>

                                                <input type="text" autocomplete="off" id="table"
                                                       class="form-control"
                                                       name="table"
                                                       placeholder="The Name Of Table That Will Be Created In Database "
                                                       required>


                                            </div>

                                            <div id="plus" class=" col-md-6 " style="margin-top: 25px ">
                                                <div class="btn btn-sm btn-primary">
                                                    <span class="la la-plus "> Add Column</span>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>

                                        <div class="row ">
                                            <span onclick="$('.el1').remove()"
                                                  class="el1 btn btn-sm btn-danger mt-4 p-2 mb-4" width="25"
                                                  height="25">X</span>

                                            <div class="el1 form-group col-3 mb-2">
                                                <label for="file" class="">Columns Name:
                                                    <input name="columnName[]" placeholder="name of column"
                                                           class="attr form-control" type="text"
                                                           required>

                                                </label>
                                            </div>
                                            <div class="el1 form-group col-3 mb-2">
                                                <label for="file" class="">DataType:

                                                    <select class="form-control" name="DataType[]">
                                                        <option value="integer">integer</option>
                                                        <option value="tinyInteger">tinyInteger</option>
                                                        <option value="string">string</option>
                                                        <option value="unsigned">unsigned</option>
                                                        <option value="text">text</option>
                                                        <option value="unsignedInteger">unsignedInteger</option>
                                                        <option value="bigInteger">bigInteger</option>
                                                        <option value="binary">binary</option>
                                                        <option value="boolean">boolean</option>
                                                        <option value="date">date</option>
                                                        <option value="geometry">geometry</option>
                                                        <option value="geometryCollection">geometryCollection</option>
                                                        <option value="increments">increments</option>
                                                        <option value="longText">longText</option>
                                                        <option value="json">json</option>
                                                        <option value="jsonb">jsonb</option>
                                                        <option value="macAddress">macAddress</option>
                                                        <option value="morphs">morphs</option>
                                                        <option value="uuidMorphs">uuidMorphs</option>
                                                        <option value="softDeletes">softDeletes</option>
                                                        <option value="uuid">uuid</option>
                                                        <option value="year">year</option>
                                                        <option value="timestamps">timestamps</option>


                                                    </select>

                                                </label>
                                            </div>
                                            <div class="el1 form-group col-3 mb-2 mr-5">
                                                <label for="file" class="">Keys And Default :
                                                    <select class="form-control" name="key[]">
                                                        <option value="0">NoDefault</option>
                                                        {{--                                                        <option id="default" value="default">default</option>--}}

                                                        <option value="unique">unique</option>
                                                        <option value="unsigned">unsigned</option>
                                                        <option value="useCurrent">useCurrent</option>
                                                        <option value="always">always</option>
                                                        <option value="useCurrentOnUpdate">useCurrentOnUpdate</option>
                                                        <option value="nullable">nullable</option>

                                                    </select>
                                                </label>
                                            </div>

                                            {{--                                            <div id="set" class=" form-group col-2  mb-2 mt-1"></div>--}}
                                            <div class="col-name form-group col-3  mb-2 "></div>
                                            <div class="dataType form-group col-3  mb-2 "></div>
                                            <div class="key form-group col-3  mb-2 "></div>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="migrate" class="custom-control-input"
                                                   id="defaultUncheckedChoose">
                                            <label class="custom-control-label" for="defaultUncheckedChoose">Do you want to
                                                create Table in Database ? </label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="route" class="custom-control-input"
                                                   id="defaultCheckedChoose" >
                                            <label class="custom-control-label" for="defaultCheckedChoose">Do you want to
                                                create ROUTS ? </label>
                                        </div>
                                        <label class="ml-2 mt-2" > choose Middleware Type ?</label>

                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="middleware" value="" class="custom-control-input" id="defaultChecked" checked>
                                            <label class="custom-control-label ml-4" for="defaultChecked"> Without Middleware</label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="middleware" value="guest" class="custom-control-input" id="defaultUnChecked">
                                            <label class="custom-control-label ml-4" for="defaultUnChecked"> guest</label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="middleware" value="auth" class="custom-control-input" id="defaultUnCheckedRadio">
                                            <label class="custom-control-label ml-4" for="defaultUnCheckedRadio"> auth</label>
                                        </div>


                                        <div class="row">
                                            <div class="col-12 form-actions">
                                                <button onclick="history.back()" type="button"
                                                        class="btn btn-warning mr-1">
                                                    <i class="ft-x"></i> Cancel
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


<script>
    $('#plus').on('click', function () {

        // var generate = Math.random().toString(30).substr(1, 10);
        //
        // var number = Array(generate);
        //
        // $('.col').addClass(number);
        // $(number).on('click', HtmlClass);
        //
        // var HtmlClass = $(number).remove();
        $('.col-name').append(
            '<input name="columnName[]" placeholder="name of column" class="attr form-control mb-2" type="text" required>');

        $('.dataType').append(
            '<select class="form-control mb-2" name="DataType[]">\n' +
            '<option value="integer">integer</option>' +
            '<option value="tinyInteger">tinyInteger</option>' +
            '<option value="string">string</option>' +
            '<option value="unsigned">unsigned</option>' +
            '<option value="text">text</option>' +
            '<option value="unsignedInteger">unsignedInteger</option>' +
            '<option value="bigInteger">bigInteger</option>' +
            '<option value="binary">binary</option>' +
            '<option value="boolean">boolean</option>' +
            '<option value="date">date</option>' +
            '<option value="geometry">geometry</option>' +
            '<option value="geometryCollection">geometryCollection</option>' +
            '<option value="increments">increments</option>' +
            '<option value="longText">longText</option>' +
            '<option value="json">json</option>' +
            '<option value="jsonb">jsonb</option>' +
            '<option value="macAddress">macAddress</option>' +
            '<option value="morphs">morphs</option>' +
            '<option value="uuidMorphs">uuidMorphs</option>' +
            '<option value="softDeletes">softDeletes</option>' +
            '<option value="uuid">uuid</option>' +
            'option value="year">year</option></div>' +
            '</select>');
        $('.key').append(
            '<select class="form-control mb-2" name="key[]" >\n' +
            '<option value="0">NoDefault</option>' +
            // '<option  value="default">default</option>\n' +
            '<option value="unique">unique</option>' +
            '<option value="unsigned">unsigned</option>' +
            '<option value="useCurrent">useCurrent</option>' +
            '<option value="always">always</option>' +
            '<option value="useCurrentOnUpdate">useCurrentOnUpdate</option>' +
            '<option value="nullable">nullable</option>' +
            '</select>'
        );
    });


    // $('select').on('click', function () {
    //     if ($(this).val() === 'default') {
    //         return $('#set').append('<input class="form-control mb-2 mt-3" placeholder="set defaut value" type="text" value="" required>');
    //     }
    //     return $('#set').removeAttr('<input class="form-control mb-2 mt-3" placeholder="set defaut value" type="text" value="" required>');
    //
    // });
</script>




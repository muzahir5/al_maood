@extends('user.layouts.default')
@section('title', 'Privacy Policy')
@section('content')
                <!-- Begin Page Content -->
                <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Privacy Policy</h1>
                </div>
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">
                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                <ul>
                                    <li>{!! \Session::get('success') !!}</li>
                                </ul>
                            </div>
                        @endif
                        </h1>
                    </div>
                    <!-- Content Row -->
                    <div class="row text-center">
                        <p>A: 
                            This is Al Maood.com’s (“AlMaood.com”) online privacy policy (“Policy”). This policy applies only to activities AlMaood.com engages in on its website and does not apply to AlMaood.com activities that are "offline" or unrelated to the website.
                        </p>
                        <p>B: 
                            AlMaood.com collects certain anonymous data regarding the usage of the website. This information does not personally identify users, by itself or in combination with other information, and is gathered to improve the performance of the website. The anonymous data collected by the AlMaood.com website can include information such as the type of browser you are using and the length of the visit to the website/Mobile App. You may also be asked to provide personally identifiable information on the AlMaood.com website/Mobile App, which may include your name, address, telephone number and e-mail address. This information can be gathered when feedback or e-mails are sent to AlMaood.com, when you register for services. In all such cases you have the option of providing us with personally identifiable information.
                        </p>
                        <p>C: 
                            COOKIES. Cookies are small bits of data cached in a user’s browser. AlMaood.com utilizes cookies to determine whether or not you have visited the home page in the past. However, no other user information is gathered.
                        </p>
                        <p>D: 
                            AlMaood.com may use non-personal "aggregated data" to enhance the operation of our website, or analyze interest in the areas of our website. Additionally, if you provide AlMaood.com with content for publishing or feedback, we may publish your user name or other identifying data with your permission.
                        </p>
                        <p>E: 
                            OTHER WEBSITES. AlMaood.com is not responsible for the privacy policies of websites to which it links. If you provide any information to such third parties different rules regarding the collection and use of your personal information may apply. We strongly suggest you review such third party’s privacy policies before providing any data to them. We are not responsible for the policies or practices of third parties. Please be aware that our website may contain links to other websites on the Internet that are owned and operated by third parties. The information practices of those websites linked are not covered by this Policy. Those linked websites may send their own cookies or clear GIFs to users, collect data or solicit personally identifiable information. We cannot control this collection of information. You should contact these entities directly if you have any questions about their use of the information that they collect.
                        </p>
                        <p>F: 
                            CORRECTIONS AND UPDATES. If you wish to modify or update any information AlMaood.com has received, please contact hello@AlMaood.com.
                        </p>
                        <p>G: 
                            MODIFICATIONS OF THE PRIVACY POLICY. AlMaood.com. The Website Policies and Terms & Conditions will be changed or updated occasionally to meet the requirements and standards. Therefore the Customers’ are encouraged to frequently visit these sections in order to be updated about the changes on the website. Modifications will be effective on the day they are posted.
                        </p>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
@endsection

@section('footer-js-content')
<script type="text/javascript">

    $(document).ready(function () {     
        
        $('#data_tbl').DataTable( {
                "pagingType": "full_numbers",
                "pageLength": 50
        } );

        setTimeout(function(){
            $('.alert').css('display','none');
        }, 5000);

    }); 
</script>
@endsection
@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">
    <div class="row">
        
    </div>
</div>


@endsection
<!-- <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">transaksi</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-wizard1" class="mt-3 text-center">
                        <ul id="top-tab-list" class="p-0 row list-inline">
                            <li class="mb-2 col-lg-4 col-md-6 text-start active" id="account">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg" width="20"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="dark-wizard">Pembelian</span>
                                </a>
                            </li>
                            <li id="personal" class="mb-2 col-lg-4 col-md-6 text-start">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg" width="20"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="dark-wizard">Pengambilan</span>
                                </a>
                            </li>
                            <li id="confirm" class="mb-2 col-lg-4 col-md-6 text-start">
                                <a href="javascript:void();">
                                    <div class="iq-icon me-3">
                                        <svg class="svg-icon icon-20" xmlns="http://www.w3.org/2000/svg" width="20"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="dark-wizard">Selesai</span>
                                </a>
                            </li>
                        </ul>
                        <fieldset>
                            <div class="form-card text-start">
                                <div class="row">
                                    <div class="col-12">
                                        <h3 class="mb-4">Detail Pembeli TBS:</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Pembeli: </label>
                                            <input class="form-control" Value="Koperasi ABC">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">kontak: </label>
                                            <input class="form-control" Value="08969647579">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nomor Armada: </label>
                                            <input class="form-control" Value="KB 2162 OC">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Penjemputan: </label>
                                            <input class="form-control" Value="9 oktober 2025">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" name="next" class="btn btn-primary next action-button float-end"
                                value="Next">Next</button>
                        </fieldset>
                        <fieldset>
                            <div class="form-card text-start">
                                <div class="row">
                                    <div class="col-12">
                                        <h3 class="mb-4">Detail Pembelian:</h3>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Jumlah TBS yang diambil: </label>
                                            <input class="form-control" Value="150 Kg">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Harga Perkilo: </label>
                                            <input class="form-control" Value="Rp. 3000">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Kualitas: </label>
                                            <input class="form-control" Value="Cukup">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Total Transaksi: </label>
                                            <input class="form-control" Value="Rp. 150000">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" name="next" class="btn btn-primary next action-button float-end"
                                value="Next">Next</button>
                            <button type="button" name="previous"
                                class="btn btn-dark previous action-button-previous float-end me-1 text-white"
                                value="Previous">Previous</button>
                        </fieldset>
                        <fieldset>
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7">
                                        <h3 class="mb-4 text-left">Finish:</h3>
                                    </div>
                                </div>
                                <br><br>
                                <h2 class="text-center text-success"><strong>SUCCESS !</strong></h2>
                                <br>
                                <div class="row justify-content-center">
                                    <div class="col-3"> <img src="../../assets/images/pages/img-success.png"
                                            class="img-fluid" alt="fit-image"> </div>
                                </div>
                                <br><br>
                                <div class="row justify-content-center">
                                    <div class="text-center col-7">
                                        <h5 class="text-center purple-text">You Have Successfully Signed Up</h5>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div> -->
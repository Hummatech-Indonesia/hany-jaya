@extends('dashboard.layouts.dashboard') @section('content')
<div class="container-fluid">
    <!--  Owl carousel -->
    <div class="owl-carousel counter-carousel owl-theme">
        <div class="item">
            <div class="card border-0 zoom-in bg-light-primary shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img
                            src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg"
                            width="50"
                            height="50"
                            class="mb-3"
                            alt=""
                        />
                        <p class="fw-semibold fs-3 text-primary mb-1">
                            Employees
                        </p>
                        <h5 class="fw-semibold text-primary mb-0">96</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="card border-0 zoom-in bg-light-warning shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img
                            src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-briefcase.svg"
                            width="50"
                            height="50"
                            class="mb-3"
                            alt=""
                        />
                        <p class="fw-semibold fs-3 text-warning mb-1">
                            Clients
                        </p>
                        <h5 class="fw-semibold text-warning mb-0">3,650</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="card border-0 zoom-in bg-light-info shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img
                            src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-mailbox.svg"
                            width="50"
                            height="50"
                            class="mb-3"
                            alt=""
                        />
                        <p class="fw-semibold fs-3 text-info mb-1">Projects</p>
                        <h5 class="fw-semibold text-info mb-0">356</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="card border-0 zoom-in bg-light-danger shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img
                            src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-favorites.svg"
                            width="50"
                            height="50"
                            class="mb-3"
                            alt=""
                        />
                        <p class="fw-semibold fs-3 text-danger mb-1">Events</p>
                        <h5 class="fw-semibold text-danger mb-0">696</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="card border-0 zoom-in bg-light-success shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img
                            src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-speech-bubble.svg"
                            width="50"
                            height="50"
                            class="mb-3"
                            alt=""
                        />
                        <p class="fw-semibold fs-3 text-success mb-1">
                            Payroll
                        </p>
                        <h5 class="fw-semibold text-success mb-0">$96k</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="card border-0 zoom-in bg-light-info shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <img
                            src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-connect.svg"
                            width="50"
                            height="50"
                            class="mb-3"
                            alt=""
                        />
                        <p class="fw-semibold fs-3 text-info mb-1">Reports</p>
                        <h5 class="fw-semibold text-info mb-0">59</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Row 1 -->
    <!-- <div class="row">
        <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div
                        class="d-sm-flex d-block align-items-center justify-content-between mb-9"
                    >
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">
                                Revenue Updates
                            </h5>
                            <p class="card-subtitle mb-0">Overview of Profit</p>
                        </div>
                        <div>
                            <select class="form-select">
                                <option value="1">March 2023</option>
                                <option value="2">April 2023</option>
                                <option value="3">May 2023</option>
                                <option value="4">June 2023</option>
                            </select>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-8">
                            <div id="chart"></div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="d-flex align-items-center mb-4 pb-1">
                                <div
                                    class="p-8 bg-light-primary rounded-1 me-3 d-flex align-items-center justify-content-center"
                                >
                                    <i
                                        class="ti ti-grid-dots text-primary fs-6"
                                    ></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 fs-7 fw-semibold">
                                        $63,489.50
                                    </h4>
                                    <p class="fs-3 mb-0">Total Earnings</p>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex align-items-baseline mb-4">
                                    <span
                                        class="round-8 bg-primary rounded-circle me-6"
                                    ></span>
                                    <div>
                                        <p class="fs-3 mb-1">
                                            Earnings this month
                                        </p>
                                        <h6 class="fs-5 fw-semibold mb-0">
                                            $48,820
                                        </h6>
                                    </div>
                                </div>
                                <div
                                    class="d-flex align-items-baseline mb-4 pb-1"
                                >
                                    <span
                                        class="round-8 bg-secondary rounded-circle me-6"
                                    ></span>
                                    <div>
                                        <p class="fs-3 mb-1">
                                            Expense this month
                                        </p>
                                        <h6 class="fs-5 fw-semibold mb-0">
                                            $26,498
                                        </h6>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-primary w-100">
                                        View Full Report
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12 col-md-6 col-sm-12">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h5 class="card-title mb-9 fw-semibold">
                                        Yearly Breakup
                                    </h5>
                                    <h4 class="fw-semibold mb-3">$36,358</h4>
                                    <div class="d-flex align-items-center mb-3">
                                        <span
                                            class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center"
                                        >
                                            <i
                                                class="ti ti-arrow-up-left text-success"
                                            ></i>
                                        </span>
                                        <p class="text-dark me-1 fs-3 mb-0">
                                            +9%
                                        </p>
                                        <p class="fs-3 mb-0">last year</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="me-4">
                                            <span
                                                class="round-8 bg-primary rounded-circle me-2 d-inline-block"
                                            ></span>
                                            <span class="fs-2">2023</span>
                                        </div>
                                        <div>
                                            <span
                                                class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"
                                            ></span>
                                            <span class="fs-2">2023</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-center">
                                        <div id="breakup"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row alig n-items-start">
                                <div class="col-8">
                                    <h5 class="card-title mb-9 fw-semibold">
                                        Monthly Earnings
                                    </h5>
                                    <h4 class="fw-semibold mb-3">$6,820</h4>
                                    <div class="d-flex align-items-center pb-1">
                                        <span
                                            class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center"
                                        >
                                            <i
                                                class="ti ti-arrow-down-right text-danger"
                                            ></i>
                                        </span>
                                        <p class="text-dark me-1 fs-3 mb-0">
                                            +9%
                                        </p>
                                        <p class="fs-3 mb-0">last year</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">
                                        <div
                                            class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center"
                                        >
                                            <i
                                                class="ti ti-currency-dollar fs-6"
                                            ></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="earning"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>
@endsection

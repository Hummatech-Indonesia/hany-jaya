@extends('dashboard.layouts.dashboard') @section('content')
<div class="container-fluid">
    <div
        class="card bg-light-info shadow-none position-relative overflow-hidden"
    >
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Kasir</h4>
                    <p>List kasir di toko anda.</p>
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalAddSuplier"
                    >
                        Tambah Pemasok
                    </button>

                    <!-- Modal -->
                    <div
                        class="modal fade"
                        id="modalAddSuplier"
                        data-bs-backdrop="static"
                        data-bs-keyboard="false"
                        tabindex="-1"
                        aria-labelledby="modalAddSuplierLabel"
                        aria-hidden="true"
                    >
                        <div
                            class="modal-dialog modal-dialog-scrollable modal-lg"
                        >
                            <div class="modal-content">
                                <div
                                    class="modal-header d-flex align-items-center"
                                >
                                    <h4
                                        class="modal-title"
                                        id="myLargeModalLabel"
                                    >
                                        Tambah Pemasok
                                    </h4>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <div class="modal-body row">
                                    <div class="col-md-6 mb-4">
                                        <label
                                            for="exampleInputPassword1"
                                            class="form-label fw-semibold"
                                            >Nama Pemasok</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="exampleInputtext"
                                            placeholder="John Deo"
                                        />
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label
                                            for="exampleInputPassword1"
                                            class="form-label fw-semibold"
                                            >Produk</label
                                        >
                                        <select
                                            id="select-product"
                                            class="select2 form-control"
                                            style="width: 100%; height: 36px"
                                        >
                                            <option>Select</option>
                                            <optgroup
                                                label="Alaskan/Hawaiian Time Zone"
                                            >
                                                <option value="AK">
                                                    Alaska
                                                </option>
                                                <option value="HI">
                                                    Hawaii
                                                </option>
                                            </optgroup>
                                            <optgroup label="Pacific Time Zone">
                                                <option value="CA">
                                                    California
                                                </option>
                                                <option value="NV">
                                                    Nevada
                                                </option>
                                                <option value="OR">
                                                    Oregon
                                                </option>
                                                <option value="WA">
                                                    Washington
                                                </option>
                                            </optgroup>
                                            <optgroup
                                                label="Mountain Time Zone"
                                            >
                                                <option value="AZ">
                                                    Arizona
                                                </option>
                                                <option value="CO">
                                                    Colorado
                                                </option>
                                                <option value="ID">
                                                    Idaho
                                                </option>
                                                <option value="MT">
                                                    Montana
                                                </option>
                                                <option value="NE">
                                                    Nebraska
                                                </option>
                                                <option value="NM">
                                                    New Mexico
                                                </option>
                                                <option value="ND">
                                                    North Dakota
                                                </option>
                                                <option value="UT">Utah</option>
                                                <option value="WY">
                                                    Wyoming
                                                </option>
                                            </optgroup>
                                            <optgroup label="Central Time Zone">
                                                <option value="AL">
                                                    Alabama
                                                </option>
                                                <option value="AR">
                                                    Arkansas
                                                </option>
                                                <option value="IL">
                                                    Illinois
                                                </option>
                                                <option value="IA">Iowa</option>
                                                <option value="KS">
                                                    Kansas
                                                </option>
                                                <option value="KY">
                                                    Kentucky
                                                </option>
                                                <option value="LA">
                                                    Louisiana
                                                </option>
                                                <option value="MN">
                                                    Minnesota
                                                </option>
                                                <option value="MS">
                                                    Mississippi
                                                </option>
                                                <option value="MO">
                                                    Missouri
                                                </option>
                                                <option value="OK">
                                                    Oklahoma
                                                </option>
                                                <option value="SD">
                                                    South Dakota
                                                </option>
                                                <option value="TX">
                                                    Texas
                                                </option>
                                                <option value="TN">
                                                    Tennessee
                                                </option>
                                                <option value="WI">
                                                    Wisconsin
                                                </option>
                                            </optgroup>
                                            <optgroup label="Eastern Time Zone">
                                                <option value="CT">
                                                    Connecticut
                                                </option>
                                                <option value="DE">
                                                    Delaware
                                                </option>
                                                <option value="FL">
                                                    Florida
                                                </option>
                                                <option value="GA">
                                                    Georgia
                                                </option>
                                                <option value="IN">
                                                    Indiana
                                                </option>
                                                <option value="ME">
                                                    Maine
                                                </option>
                                                <option value="MD">
                                                    Maryland
                                                </option>
                                                <option value="MA">
                                                    Massachusetts
                                                </option>
                                                <option value="MI">
                                                    Michigan
                                                </option>
                                                <option value="NH">
                                                    New Hampshire
                                                </option>
                                                <option value="NJ">
                                                    New Jersey
                                                </option>
                                                <option value="NY">
                                                    New York
                                                </option>
                                                <option value="NC">
                                                    North Carolina
                                                </option>
                                                <option value="OH">Ohio</option>
                                                <option value="PA">
                                                    Pennsylvania
                                                </option>
                                                <option value="RI">
                                                    Rhode Island
                                                </option>
                                                <option value="SC">
                                                    South Carolina
                                                </option>
                                                <option value="VT">
                                                    Vermont
                                                </option>
                                                <option value="VA">
                                                    Virginia
                                                </option>
                                                <option value="WV">
                                                    West Virginia
                                                </option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label
                                            for="exampleInputPassword1"
                                            class="form-label fw-semibold"
                                            >Alamat</label
                                        >
                                        <textarea
                                            class="form-control p-7"
                                            name=""
                                            id=""
                                            cols="20"
                                            rows="1"
                                            placeholder="Hi, Do you  have a moment to talk Jeo ?"
                                        ></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-light-danger text-danger font-medium waves-effect text-start"
                                        data-bs-dismiss="modal"
                                    >
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img
                            src="{{
                                asset('assets/images/breadcrumb/ChatBc.png')
                            }}"
                            alt=""
                            class="img-fluid mb-n4"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="widget-content searchable-container list">
        <!-- --------------------- start Contact ---------------- -->
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 col-xl-3">
                    <form class="position-relative">
                        <input
                            type="text"
                            class="form-control product-search ps-5"
                            id="input-search"
                            placeholder="Search Contacts..."
                        />
                        <i
                            class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"
                        ></i>
                    </form>
                </div>
                <div
                    class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0"
                >
                    <div class="action-btn show-btn" style="display: none">
                        <a
                            href="javascript:void(0)"
                            class="delete-multiple btn-light-danger btn me-2 text-danger d-flex align-items-center font-medium"
                        >
                            <i class="ti ti-trash text-danger me-1 fs-5"></i>
                            Delete All Row
                        </a>
                    </div>
                    <a
                        href="javascript:void(0)"
                        id="btn-add-contact"
                        class="btn btn-info d-flex align-items-center"
                    >
                        <i class="ti ti-users text-white me-1 fs-5"></i> Add
                        Contact
                    </a>
                </div>
            </div>
        </div>
        <!-- ---------------------
                        end Contact
                    ---------------- -->
        <!-- Modal -->
        <div
            class="modal fade"
            id="addContactModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="addContactModalTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h5 class="modal-title">Contact</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="add-contact-box">
                            <div class="add-contact-content">
                                <form id="addContactModalTitle">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 contact-name">
                                                <input
                                                    type="text"
                                                    id="c-name"
                                                    class="form-control"
                                                    placeholder="Name"
                                                />
                                                <span
                                                    class="validation-text text-danger"
                                                ></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3 contact-email">
                                                <input
                                                    type="text"
                                                    id="c-email"
                                                    class="form-control"
                                                    placeholder="Email"
                                                />
                                                <span
                                                    class="validation-text text-danger"
                                                ></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div
                                                class="mb-3 contact-occupation"
                                            >
                                                <input
                                                    type="text"
                                                    id="c-occupation"
                                                    class="form-control"
                                                    placeholder="Occupation"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3 contact-phone">
                                                <input
                                                    type="text"
                                                    id="c-phone"
                                                    class="form-control"
                                                    placeholder="Phone"
                                                />
                                                <span
                                                    class="validation-text text-danger"
                                                ></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3 contact-location">
                                                <input
                                                    type="text"
                                                    id="c-location"
                                                    class="form-control"
                                                    placeholder="Location"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            id="btn-add"
                            class="btn btn-success rounded-pill px-4"
                        >
                            Add
                        </button>
                        <button
                            id="btn-edit"
                            class="btn btn-success rounded-pill px-4"
                        >
                            Save
                        </button>
                        <button
                            class="btn btn-danger rounded-pill px-4"
                            data-bs-dismiss="modal"
                        >
                            Discard
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-body">
            <div class="table-responsive">
                <table class="table search-table align-middle text-nowrap">
                    <thead class="header-item">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Location</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <!-- start row -->
                        <tr class="search-items">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img
                                        src="{{
                                            asset(
                                                'assets/images/profile/user-1.jpg'
                                            )
                                        }}"
                                        alt="avatar"
                                        class="rounded-circle"
                                        width="35"
                                    />
                                    <div class="ms-3">
                                        <div class="user-meta-info">
                                            <h6
                                                class="user-name mb-0"
                                                data-name="Emma Adams"
                                            >
                                                Emma Adams
                                            </h6>
                                            <span
                                                class="user-work fs-3"
                                                data-occupation="Web Developer"
                                                >Web Developer</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="usr-email-addr"
                                    data-email="adams@mail.com"
                                    >adams@mail.com</span
                                >
                            </td>
                            <td>
                                <span
                                    class="usr-location"
                                    data-location="Boston, USA"
                                    >Boston, USA</span
                                >
                            </td>
                            <td>
                                <span
                                    class="usr-ph-no"
                                    data-phone="+1 (070) 123-4567"
                                    >+91 (070) 123-4567</span
                                >
                            </td>
                            <td>
                                <div class="action-btn">
                                    <a
                                        href="javascript:void(0)"
                                        class="text-info edit"
                                    >
                                        <i class="ti ti-eye fs-5"></i>
                                    </a>
                                    <a
                                        href="javascript:void(0)"
                                        class="text-dark delete ms-2"
                                    >
                                        <i class="ti ti-trash fs-5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <!-- end row -->
                        <!-- start row -->
                        <tr class="search-items">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img
                                        src="{{
                                            asset(
                                                'assets/images/profile/user-2.jpg'
                                            )
                                        }}"
                                        alt="avatar"
                                        class="rounded-circle"
                                        width="35"
                                    />
                                    <div class="ms-3">
                                        <div class="user-meta-info">
                                            <h6
                                                class="user-name mb-0"
                                                data-name="Olivia Allen"
                                            >
                                                Olivia Allen
                                            </h6>
                                            <span
                                                class="user-work fs-3"
                                                data-occupation="Web Designer"
                                                >Web Designer</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="usr-email-addr"
                                    data-email="allen@mail.com"
                                    >allen@mail.com</span
                                >
                            </td>
                            <td>
                                <span
                                    class="usr-location"
                                    data-location="Sydney, Australia"
                                    >Sydney, Australia</span
                                >
                            </td>
                            <td>
                                <span
                                    class="usr-ph-no"
                                    data-phone="+91 (125) 450-1500"
                                    >+91 (125) 450-1500</span
                                >
                            </td>
                            <td>
                                <div class="action-btn">
                                    <a
                                        href="javascript:void(0)"
                                        class="text-info edit"
                                    >
                                        <i class="ti ti-eye fs-5"></i>
                                    </a>
                                    <a
                                        href="javascript:void(0)"
                                        class="text-dark delete ms-2"
                                    >
                                        <i class="ti ti-trash fs-5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <!-- end row -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

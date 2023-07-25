@extends('layouts.admin.app')

@section('content')
    @include('flash::message')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ translate('calendarTranslation.ReservationsList') }}</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('dashboard') }}"
                                class="text-muted text-hover-primary">{{ translate('calendarTranslation.Dashboard') }}</a>
                        </li>
                        <input id="locale" class="d-none hidden" value="{{ Cookie::get(APP_LOCALE) }}">
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('calendar.index') }}"
                                class="text-muted text-hover-primary">{{ translate('calendarTranslation.Calendar') }}</a>
                        </li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <h2 class="card-title fw-bold">{{ translate('calendarTranslation.Calendar') }}</h2>
                        <div class="card-toolbar">
                            @can(CREATE_RESERVATION_PERMISSION)
                                <button class="btn btn-flex btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_add_reservation">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                                rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->{{ translate('calendarTranslation.AddReservation') }}
                                </button>
                            @endcan
                            <!--begin::Add Resource-->
                            @can(CREATE_COURSE_PERMISSION)
                                <button type="button" class="ms-10 btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_add_course">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                                rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->{{ translate('courseTranslation.AddCourse') }}
                                </button>
                            @endcan
                            <!--end::Add Resource-->
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Calendar-->
                        <div id="kt_calendar_app"></div>
                        <!--end::Calendar-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Modal - Add schedule-->
                <div class="modal fade" id="kt_modal_add_reservation" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bold">{{ translate('calendarTranslation.AddReservation') }}</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                    data-kt-reservation-modal-action="close">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                                rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                            <rect x="7.41422" y="6" width="16" height="2"
                                                rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <!--begin::Form-->
                                <form id="kt_modal_add_reservation_form" class="form"
                                    action="{{ route('reservations.store') }}" method="POST">
                                    @csrf
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label
                                            class="required fs-6 fw-semibold form-label mb-2">{{ translate('calendarTranslation.ReservationName') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="name" />
                                        {{-- <input type="hidden" class="d-none form-control form-control-solid" name="resource_id" value="{{$resources->name}}"/> --}}
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label
                                            class="required fw-semibold fs-6 mb-2">{{ translate('calendarTranslation.UserName') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <select name="user_id" class="form-select form-select-solid"
                                                data-control="select2" data-hide-search="true" data-placeholder="التصنيف"
                                                required>
                                                @foreach ($users as $user)
                                                    @if ($user->email_verified_at != null)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--end::Col-->
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label
                                            class="required fw-semibold fs-6 mb-2">{{ translate('calendarTranslation.ResourceName') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <select name="resource_id" class="form-select form-select-solid"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="{{ translate('calendarTranslation.ResourceName') }}"
                                                required>
                                                @foreach ($resources as $resource)
                                                    <option value="{{ $resource->id }}">{{ $resource->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--end::Col-->
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label
                                            class="required fw-semibold fs-6 mb-2">{{ translate('calendarTranslation.PaymentMethod') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <select name="payment_method_id" class="form-select form-select-solid"
                                                data-control="select2" data-hide-search="true"
                                                data-placeholder="Payment Method" required>
                                                @foreach ($payment_methods as $name => $id)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--end::Col-->
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->

                                    <div class="fv-row mb-7">
                                        <label for="pricing_option">{{ translate('calendarTranslation.ReservationVia') }}
                                            :</label>
                                        <select class="form-select form-select-sm form-select-solid" name="pricing_option"
                                            id="pricing_option" onclick="showInputField()">
                                            {{-- @if ($resources->price_by_hour != 0) --}}
                                            <option value="price_by_hour">
                                                {{ translate('calendarTranslation.ReservationByHours') }}</option>
                                            {{-- @endif --}}
                                            {{-- @if ($resources->price_by_day != 0) --}}
                                            <option value="price_by_day">
                                                {{ translate('calendarTranslation.ReservationByDays') }}</option>
                                            {{-- @endif --}}
                                            {{-- @if ($resources->price_by_weak != 0) --}}
                                            <option value="price_by_weak">
                                                {{ translate('calendarTranslation.ReservationByWeeks') }}</option>
                                            {{-- @endif --}}
                                            {{-- @if ($resources->price_by_month != 0) --}}
                                            <option value="price_by_month">
                                                {{ translate('calendarTranslation.ReservationByMonths') }}</option>
                                            {{-- @endif --}}
                                        </select>
                                    </div>
                                    <div class="fv-row mb-7">
                                        <input placeholder="{{ translate('calendarTranslation.HoursNumber') }}"
                                            class="form-control form-control-solid" type="text"
                                            name="price_by_hour_input" id="price_by_hour_input" style="display:none;">


                                        <input placeholder="{{ translate('calendarTranslation.DaysNumber') }}"
                                            class="form-control form-control-solid" type="text"
                                            name="price_by_day_input" id="price_by_day_input" style="display:none;">


                                        <input placeholder="{{ translate('calendarTranslation.WeeksNumber') }}"
                                            class="form-control form-control-solid" type="text"
                                            name="price_by_weak_input" id="price_by_weak_input" style="display:none;">


                                        <input placeholder="{{ translate('calendarTranslation.MonthsNumber') }}"
                                            class="form-control form-control-solid" type="text"
                                            name="price_by_month_input" id="price_by_month_input" style="display:none;">

                                    </div>


                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span class="required">{{ translate('calendarTranslation.StartDate') }}</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                data-bs-trigger="hover" data-bs-html="true"
                                                data-bs-content="Select a date & time."></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid"
                                            placeholder="{{ translate('calendarTranslation.EnterStartDate') }}"
                                            name="start_date" id="kt_modal_add_reservation_datepicker" />
                                        <!--end::Input-->
                                    </div>

                                    <div class="text-center pt-15">
                                        <button type="reset" class="btn btn-light me-3"
                                            data-kt-reservation-modal-action="cancel">{{ translate('resourceTranslation.Cancel') }}
                                        </button>
                                        <button type="submit" class="btn btn-primary"
                                            data-kt-reservation-modal-action="submit">
                                            <span
                                                class="indicator-label">{{ translate('resourceTranslation.Add') }}</span>
                                            <span
                                                class="indicator-progress">{{ translate('resourceTranslation.Waiting') }}
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
                <!--end::Modal - Add schedule-->
                <!--begin::Modal - Add schedule-->
                <div class="modal fade" id="kt_modal_edit_reservation" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bold" data-kt-calendar="title">
                                    {{ translate('calendarTranslation.UpdateReservation') }}</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                    data-kt-reservation-modal-action="close">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                height="2" rx="1" transform="rotate(-45 6 17.3137)"
                                                fill="currentColor" />
                                            <rect x="7.41422" y="6" width="16" height="2"
                                                rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <!--begin::Form-->
                                <form id="kt_modal_edit_reservation_form" class="form" action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <!--begin::Input group-->
                                    <input type="text" class="form-control form-control-solid" name="id"
                                        hidden="hidden" />
                                    <input type="text" class="form-control form-control-solid" name="resource_id"
                                        hidden="hidden" />
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label
                                            class="required fs-6 fw-semibold form-label mb-2">{{ translate('calendarTranslation.ReservationName') }}</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" name="name" />
                                        {{-- <input type="hidden" class="d-none form-control form-control-solid" name="resource_id" value="{{$resources->name}}"/> --}}
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold form-label mb-2">
                                            <span class="required">{{ translate('calendarTranslation.StartDate') }}</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                                                data-bs-trigger="hover" data-bs-html="true"
                                                data-bs-content="Select a date & time."></i>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid"
                                            placeholder="{{ translate('calendarTranslation.EnterStartDate') }}"
                                            name="start_date" id="kt_modal_edit_reservation_datepicker" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Action-->
                                    <div class="text-center pt-15">
                                        <button type="reset" class="btn btn-light me-3"
                                            data-kt-reservation-editModal-action="cancel">{{ translate('reservationTranslation.Cancel') }}
                                        </button>
                                        <button type="submit" class="btn btn-primary"
                                            data-kt-reservation-modal-action="submit"
                                            id="kt_modal_edit_reservation_submit">
                                            <span
                                                class="indicator-label">{{ translate('reservationTranslation.Update') }}</span>
                                            <span
                                                class="indicator-progress">{{ translate('reservationTranslation.Waiting') }}
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
                <!--end::Modal - Add schedule-->

                <!--begin::Modal - Add course-->
                <div class="modal fade" id="kt_modal_add_course" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header" id="kt_modal_add_course_header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bold">{{ translate('courseTranslation.AddCourse') }}</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                    data-kt-courses-modal-action="close">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                height="2" rx="1" transform="rotate(-45 6 17.3137)"
                                                fill="currentColor" />
                                            <rect x="7.41422" y="6" width="16" height="2"
                                                rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <!--begin::Form-->
                                <form id="kt_modal_add_course_form" class="form" action="{{ route('courses.store') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <!--begin::Scroll-->
                                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_course_scroll"
                                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                        data-kt-scroll-max-height="auto"
                                        data-kt-scroll-dependencies="#kt_modal_add_course_header"
                                        data-kt-scroll-wrappers="#kt_modal_add_course_scroll"
                                        data-kt-scroll-offset="300px">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label
                                                class="d-block fw-semibold fs-6 mb-5">{{ translate('courseTranslation.Image') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Image placeholder-->
                                            <style>
                                                .image-input-placeholder {
                                                    background-image: {{ asset('assets/img/avatar.jpeg') }};
                                                }

                                                [data-bs-theme="dark"] .image-input-placeholder {
                                                    background-image: {{ asset('assets/img/avatar.jpeg') }};
                                                }
                                            </style>
                                            <!--end::Image placeholder-->
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline image-input-placeholder"
                                                data-kt-image-input="true">
                                                <!--begin::Preview existing avatar-->
                                                <div class="image-input-wrapper w-125px h-125px"
                                                    style="background-image: {{ asset('assets/img/avatar.jpeg') }};">
                                                </div>
                                                <!--end::Preview existing avatar-->
                                                <!--begin::Label-->
                                                <label
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                    title="{{ translate('courseTranslation.ImageChange') }}">
                                                    <i class="bi bi-pencil-fill fs-7"></i>
                                                    <!--begin::Inputs-->
                                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="avatar_remove" />
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Cancel-->
                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                    title="{{ translate('courseTranslation.ImageRemove') }}">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                <!--end::Cancel-->
                                                <!--begin::Remove-->
                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                    title="{{ translate('courseTranslation.ImageRemove') }}">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                <!--end::Remove-->
                                            </div>
                                            <!--end::Image input-->
                                            <!--begin::Hint-->
                                            <div class="form-text">
                                                {{ translate('courseTranslation.AllowedFile') }}
                                            </div>
                                            <!--end::Hint-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label
                                                class="required fw-semibold fs-6 mb-2">{{ translate('courseTranslation.Course') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="name"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="{{ translate('courseTranslation.CoursName') }}" required />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label
                                                class="required fw-semibold fs-6 mb-2">{{ translate('calendarTranslation.ResourceName') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <!--begin::Col-->
                                            <div class="col-6">
                                                <select name="resource_id" class="form-select form-select-solid"
                                                    data-control="select2" data-hide-search="true"
                                                    data-placeholder="{{ translate('calendarTranslation.ResourceName') }}"
                                                    required>
                                                    @foreach ($resources as $resource)
                                                        <option value="{{ $resource->id }}">{{ $resource->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!--end::Col-->
                                            <!--end::Input-->
                                        </div>



                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label
                                                class="fw-semibold fs-6 mb-2">{{ translate('courseTranslation.Description') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="description"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="{{ translate('courseTranslation.Description') }}" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label
                                                class="required fw-semibold fs-6 mb-2">{{ translate('courseTranslation.Price') }}
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="number" name="price"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="{{ translate('courseTranslation.Price') }}"
                                                min="1" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label
                                                class=" fw-semibold fs-6 mb-2">{{ translate('courseTranslation.NumberSeats') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="number" name="number_seats"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="{{ translate('courseTranslation.NumberSeats') }}"
                                                min="1" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label
                                                class="required fw-semibold fs-6 mb-2">{{ translate('courseTranslation.CourseHours') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="number" name="hours"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="{{ translate('courseTranslation.CourseHours') }}"
                                                min="1" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label
                                                class="required fw-semibold fs-6 mb-2">{{ translate('courseTranslation.LectureHours') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="number" name="lecture_hours"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                placeholder="{{ translate('courseTranslation.LectureHours') }}"
                                                min="1" />
                                            <!--end::Input-->
                                        </div>

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label
                                                class="required fw-semibold fs-6 mb-2">{{ translate('courseTranslation.CourseDays') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="card">
                                                            <div class="card-body items-center">
                                                                <div class="form-check mb-4">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="course_days[]" value="0"
                                                                        id="saturday">
                                                                    <label class="form-check-label"
                                                                        for="saturday">Saturday</label>
                                                                </div>
                                                                <div class="form-check mb-4">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="course_days[]" value="1"
                                                                        id="sunday">
                                                                    <label class="form-check-label"
                                                                        for="sunday">Sunday</label>
                                                                </div>
                                                                <div class="form-check mb-4">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="course_days[]" value="2"
                                                                        id="monday">
                                                                    <label class="form-check-label"
                                                                        for="monday">Monday</label>
                                                                </div>
                                                                <div class="form-check mb-4">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="course_days[]" value="3"
                                                                        id="tuesday">
                                                                    <label class="form-check-label"
                                                                        for="tuesday">Tuesday</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card">
                                                            <div class="card-body items-center">
                                                                <h5 class="card-title">&nbsp;</h5>
                                                                <div class="form-check mb-4">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="course_days[]" value="4"
                                                                        id="wednesday">
                                                                    <label class="form-check-label"
                                                                        for="wednesday">Wednesday</label>
                                                                </div>
                                                                <div class="form-check mb-4">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="course_days[]" value="5"
                                                                        id="thursday">
                                                                    <label class="form-check-label"
                                                                        for="thursday">Thursday</label>
                                                                </div>
                                                                <div class="form-check mb-4">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="course_days[]" value="6"
                                                                        id="friday">
                                                                    <label class="form-check-label"
                                                                        for="friday">Friday</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span
                                                    class="required">{{ translate('courseTranslation.courseStartDate') }}</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-solid"
                                                placeholder="{{ translate('courseTranslation.EnterStartDate') }}"
                                                name="start_date" id="kt_modal_add_course_datepicker" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                    </div>
                                    <!--end::Scroll-->
                                    <!--begin::Actions-->
                                    <div class="text-center pt-15">
                                        <button type="reset" class="btn btn-light me-3"
                                            data-kt-courses-modal-action="cancel">{{ translate('courseTranslation.Cancel') }}
                                        </button>
                                        <button type="submit" class="btn btn-primary"
                                            data-kt-courses-modal-action="submit">
                                            <span class="indicator-label">{{ translate('courseTranslation.Add') }}</span>
                                            <span class="indicator-progress">{{ translate('courseTranslation.Waiting') }}
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
                <!--end::Modal - Add course-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
    <!--begin::Modal - New Product-->
    <div class="modal fade" id="kt_modal_view_event" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header border-0 justify-content-end">
                    <!--begin::Edit-->
                    <div class="btn btn-icon btn-sm btn-color-gray-400 btn-active-icon-primary me-2"
                        data-bs-toggle="tooltip" data-bs-dismiss="click" title="Edit Event"
                        id="kt_modal_view_event_edit">
                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                    d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                    fill="currentColor" />
                                <path
                                    d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Edit-->
                    <!--begin::Edit-->
                    <div class="btn btn-icon btn-sm btn-color-gray-400 btn-active-icon-danger me-2"
                        data-bs-toggle="tooltip" data-bs-dismiss="click" title="Delete Event"
                        id="kt_modal_view_event_delete">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                    fill="currentColor" />
                                <path opacity="0.5"
                                    d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                    fill="currentColor" />
                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Edit-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary" data-bs-toggle="tooltip"
                        title="Hide Event" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body pt-0 pb-20 px-lg-17">
                    <!--begin::Row-->
                    <div class="d-flex">
                        <!--begin::Icon-->
                        <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                        <span class="svg-icon svg-icon-1 svg-icon-muted me-5">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                    d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                    fill="currentColor" />
                                <path
                                    d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                    fill="currentColor" />
                                <path
                                    d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <!--end::Icon-->
                        <div class="mb-9">
                            <!--begin::Event name-->
                            <div class="d-flex align-items-center mb-2">
                                <span class="fs-3 fw-bold me-3" data-kt-calendar="event_id" hidden></span>
                                <span class="fs-3 fw-bold me-3" data-kt-calendar="event_name"></span>
                                <span class="badge badge-light-success" data-kt-calendar="all_day"></span>
                            </div>
                            <!--end::Event name-->
                            <!--begin::Event description-->
                            <div class="fs-6" data-kt-calendar="event_description"></div>
                            <!--end::Event description-->
                        </div>
                    </div>
                    <!--end::Row-->
                    <!--begin::Row-->
                    <div class="d-flex align-items-center mb-2">
                        <!--begin::Icon-->
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs050.svg-->
                        <span class="svg-icon svg-icon-1 svg-icon-success me-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                version="1.1">
                                <circle fill="currentColor" cx="12" cy="12" r="8" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <!--end::Icon-->
                        <!--begin::Event start date/time-->
                        <div class="fs-6">
                            <span class="fw-bold">{{ translate('calendarTranslation.Starts') }}</span>
                            <span data-kt-calendar="event_start_date"></span>
                        </div>
                        <!--end::Event start date/time-->
                    </div>
                    <!--end::Row-->
                    <!--begin::Row-->
                    <div class="d-flex align-items-center mb-9">
                        <!--begin::Icon-->
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs050.svg-->
                        <span class="svg-icon svg-icon-1 svg-icon-danger me-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                version="1.1">
                                <circle fill="currentColor" cx="12" cy="12" r="8" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <!--end::Icon-->
                        <!--begin::Event end date/time-->
                        <div class="fs-6">
                            <span class="fw-bold">{{ translate('calendarTranslation.Ends') }}</span>
                            <span data-kt-calendar="event_end_date"></span>
                        </div>
                        <!--end::Event end date/time-->
                    </div>
                    <!--end::Row-->
                    {{--                    <!--begin::Row--> --}}
                    {{--                    <div class="d-flex align-items-center"> --}}
                    {{--                        <!--begin::Icon--> --}}
                    {{--                        <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg--> --}}
                    {{--                        <span class="svg-icon svg-icon-1 svg-icon-muted me-5"> --}}
                    {{--															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> --}}
                    {{--																<path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="currentColor" /> --}}
                    {{--																<path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="currentColor" /> --}}
                    {{--															</svg> --}}
                    {{--														</span> --}}
                    {{--                        <!--end::Svg Icon--> --}}
                    {{--                        <!--end::Icon--> --}}
                    {{--                        <!--begin::Event location--> --}}
                    {{--                        <div class="fs-6" data-kt-calendar="event_location"></div> --}}
                    {{--                        <!--end::Event location--> --}}
                    {{--                    </div> --}}
                    {{--                    <!--end::Row--> --}}
                </div>
                <!--end::Modal body-->
            </div>
        </div>
    </div>
    <!--end::Modal - New Product-->

    <!--begin::Form-->
    <form class="form" id="kt_modal_delete_event_form" action="" method="POST">
        @csrf
        @method('DELETE')
    </form>
    <!--end::Form-->
@endsection
@push('scripts')
    @if (Cookie::get(APP_LOCALE) == 'ar')
        <script src="{{ asset('assets/js/custom/apps/calendar/list/table.js') }}"></script>
        <script src="{{ asset('assets/js/custom/apps/calendar/list/add-reservation.js') }}"></script>
    @else
        <script src="{{ asset('assets/js/custom/apps/calendar/list/table-en.js') }}"></script>
        <script src="{{ asset('assets/js/custom/apps/calendar/list/add-reservation-en.js') }}"></script>
    @endif
    @include('admin.dashboard.calendar.calendar')
    <script>
        function showInputField() {
            const select = document.getElementById("pricing_option");
            const selectedOption = select.options[select.selectedIndex].value;

            // Hide all input fields first
            document.getElementById("price_by_hour_input").style.display = "none";
            document.getElementById("price_by_day_input").style.display = "none";
            document.getElementById("price_by_weak_input").style.display = "none";
            document.getElementById("price_by_month_input").style.display = "none";

            // Show the input field that matches the selected option
            if (selectedOption === "price_by_hour") {
                document.getElementById("price_by_hour_input").style.display = "block";
            } else if (selectedOption === "price_by_day") {
                document.getElementById("price_by_day_input").style.display = "block";
            } else if (selectedOption === "price_by_weak") {
                document.getElementById("price_by_weak_input").style.display = "block";
            } else if (selectedOption === "price_by_month") {
                document.getElementById("price_by_month_input").style.display = "block";
            }
        }

        function showEditInputField() {
            const select = document.getElementById("edit_pricing_option");
            const selectedOption = select.options[select.selectedIndex].value;

            // Hide all input fields first
            document.getElementById("price_by_hour_input_edit").style.display = "none";
            document.getElementById("price_by_day_input_edit").style.display = "none";
            document.getElementById("price_by_weak_input_edit").style.display = "none";
            document.getElementById("price_by_month_input_edit").style.display = "none";

            // Show the input field that matches the selected option
            if (selectedOption === "price_by_hour") {
                document.getElementById("price_by_hour_input_edit").style.display = "block";
                document.getElementById("price_by_day_input_edit").style.display = "none";
                document.getElementById("price_by_weak_input_edit").style.display = "none";
                document.getElementById("price_by_month_input_edit").style.display = "none";
            } else if (selectedOption === "price_by_day") {
                document.getElementById("price_by_hour_input_edit").style.display = "none";
                document.getElementById("price_by_day_input_edit").style.display = "block";
                document.getElementById("price_by_weak_input_edit").style.display = "none";
                document.getElementById("price_by_month_input_edit").style.display = "none";
            } else if (selectedOption === "price_by_weak") {
                document.getElementById("price_by_hour_input_edit").style.display = "none";
                document.getElementById("price_by_day_input_edit").style.display = "none";
                document.getElementById("price_by_weak_input_edit").style.display = "block";
                document.getElementById("price_by_month_input_edit").style.display = "none";
            } else if (selectedOption === "price_by_month") {
                document.getElementById("price_by_hour_input_edit").style.display = "none";
                document.getElementById("price_by_day_input_edit").style.display = "none";
                document.getElementById("price_by_weak_input_edit").style.display = "none";
                document.getElementById("price_by_month_input_edit").style.display = "block";
            }
        }

        $("#kt_modal_edit_reservation_datepicker").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    </script>
@endpush

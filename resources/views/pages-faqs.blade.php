@extends('layouts.master')
@section('title')
@lang('translation.faqs')
@endsection
@section('content')

<div class="row mt-n1">
    <div class="col-lg-12">
        <div class="card rounded-0 bg-light mx-n4 mt-n4 border-0 shadow-none border-top">
            <div class="card-body px-4 py-5">
                <div class="row justify-content-center">
                    <div class="col-xxl-5 align-self-center">
                        <div class="text-center py-4">
                            <h2 class="mb-3">Frequently Asked Questions</h2>
                            <p class="text-muted fs-15 mb-0">If you can not find answer to your question in our FAQ, you can always contact us or email us. We will answer you shortly!</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="row gy-4">
    <div class="col-xxl-4 col-lg-6">
        <div>
            <div class="mb-3">
                <h5 class="fs-16 mb-0 fw-semibold">General Questions</h5>
            </div>

            <div class="accordion accordion-border-box" id="genques-accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="genques-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseOne" aria-expanded="true" aria-controls="genques-collapseOne">
                            What are FAQ questions?
                        </button>
                    </h2>
                    <div id="genques-collapseOne" class="accordion-collapse collapse show" aria-labelledby="genques-headingOne" data-bs-parent="#genques-accordion">
                        <div class="accordion-body">
                            An FAQ page <b>(short for Frequently Asked Question page)</b> is a part of your website that provides answers to common questions, assuages concerns, and overcomes objections. It's a space where customers away from your sales-focused landing pages and homepage.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="genques-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseTwo" aria-expanded="false" aria-controls="genques-collapseTwo">
                            What is FAQ process?
                        </button>
                    </h2>
                    <div id="genques-collapseTwo" class="accordion-collapse collapse" aria-labelledby="genques-headingTwo" data-bs-parent="#genques-accordion">
                        <div class="accordion-body">
                            FAQ stands for Frequently Asked Questions. It's <b>your opportunity to communicate with the most important visitors to your website</b> – those who have begun the decision-making process about whether to do business with you can't fit elsewhere on their website.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="genques-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseThree" aria-expanded="false" aria-controls="genques-collapseThree">
                            What is the purpose of FAQ?
                        </button>
                    </h2>
                    <div id="genques-collapseThree" class="accordion-collapse collapse" aria-labelledby="genques-headingThree" data-bs-parent="#genques-accordion">
                        <div class="accordion-body">
                            The purpose of a FAQ is generally to provide information on frequent questions or concerns; however, the format is a useful means of organizing information, and text consisting of questions and their answers may thus be called a FAQ regardless.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="genques-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseFour" aria-expanded="false" aria-controls="genques-collapseFour">
                            What is an online FAQ?
                        </button>
                    </h2>
                    <div id="genques-collapseFour" class="accordion-collapse collapse" aria-labelledby="genques-headingFour" data-bs-parent="#genques-accordion">
                        <div class="accordion-body">
                            FAQs stand for frequently asked questions. It is one of the many crucial pages of your website. It gives your customers answers to recurring and common questions and addresses their concerns public product documentation that is released at the same time.
                        </div>
                    </div>
                </div>
            </div>
            <!--end accordion-->
        </div>
    </div>
    <!--end col-->

    <div class="col-xxl-4 col-lg-6">
        <div>
            <div class="mb-3">
                <h5 class="fs-16 mb-0 fw-semibold">Manage Account</h5>
            </div>

            <div class="accordion accordion-border-box" id="manageaccount-accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="manageaccount-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#manageaccount-collapseOne" aria-expanded="false" aria-controls="manageaccount-collapseOne">
                            What is account management process?
                        </button>
                    </h2>
                    <div id="manageaccount-collapseOne" class="accordion-collapse collapse" aria-labelledby="manageaccount-headingOne" data-bs-parent="#manageaccount-accordion">
                        <div class="accordion-body">
                            If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages. It will be as simple their most common words.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="manageaccount-headingTwo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#manageaccount-collapseTwo" aria-expanded="true" aria-controls="manageaccount-collapseTwo">
                            Why is account management important?
                        </button>
                    </h2>
                    <div id="manageaccount-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="manageaccount-headingTwo" data-bs-parent="#manageaccount-accordion">
                        <div class="accordion-body">
                            The new common language will be more simple and regular than the existing European languages. It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="manageaccount-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#manageaccount-collapseThree" aria-expanded="false" aria-controls="manageaccount-collapseThree">
                            What is account manager role?
                        </button>
                    </h2>
                    <div id="manageaccount-collapseThree" class="accordion-collapse collapse" aria-labelledby="manageaccount-headingThree" data-bs-parent="#manageaccount-accordion">
                        <div class="accordion-body">
                            he wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="manageaccount-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#manageaccount-collapseFour" aria-expanded="false" aria-controls="manageaccount-collapseFour">
                            What is a key account strategy?
                        </button>
                    </h2>
                    <div id="manageaccount-collapseFour" class="accordion-collapse collapse" aria-labelledby="manageaccount-headingFour" data-bs-parent="#manageaccount-accordion">
                        <div class="accordion-body">
                            Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis aliquam ultrices mauris.
                        </div>
                    </div>
                </div>
            </div>
            <!--end accordion-->
        </div>
    </div>
    <!--end col-->

    <div class="col-xxl-4 col-lg-6 align-self-center">
        <div class="text-center">
            <div class="mb-4">
                <img src="{{ URL::asset('build/images/faq.png') }}" alt="" height="200">
            </div>
            <h4>Any Questions ?</h4>
            <p class="text-muted mb-4">You can ask anything you want to know about Feedback.</p>
            <div class="hstack flex-wrap gap-2 justify-content-center">
                <button type="button" class="btn btn-primary btn-label rounded-pill"><i class="ri-mail-line label-icon align-middle rounded-pill fs-16"></i> Email Us</button>
                <button type="button" class="btn btn-info btn-label rounded-pill"><i class="ri-twitter-line label-icon align-middle rounded-pill fs-16"></i> Send Us Tweet</button>
            </div>
        </div>
    </div>
    <!--end col-->

    <div class="col-xxl-12 col-lg-6">
        <div>
            <div class="mb-3">
                <h5 class="fs-16 mb-0 fw-semibold">Privacy &amp; Security</h5>
            </div>

            <div class="accordion accordion-border-box" id="privacy-accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="privacy-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#privacy-collapseOne" aria-expanded="true" aria-controls="privacy-collapseOne">
                            Which is important privacy or security?
                        </button>
                    </h2>
                    <div id="privacy-collapseOne" class="accordion-collapse collapse show" aria-labelledby="privacy-headingOne" data-bs-parent="#privacy-accordion">
                        <div class="accordion-body">
                            If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages. It will be as simple their most common words.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="privacy-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#privacy-collapseTwo" aria-expanded="false" aria-controls="privacy-collapseTwo">
                            What is security and privacy?
                        </button>
                    </h2>
                    <div id="privacy-collapseTwo" class="accordion-collapse collapse" aria-labelledby="privacy-headingTwo" data-bs-parent="#privacy-accordion">
                        <div class="accordion-body">
                            The new common language will be more simple and regular than the existing European languages. It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="privacy-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#privacy-collapseThree" aria-expanded="false" aria-controls="privacy-collapseThree">
                            How can I protect my privacy?
                        </button>
                    </h2>
                    <div id="privacy-collapseThree" class="accordion-collapse collapse" aria-labelledby="privacy-headingThree" data-bs-parent="#privacy-accordion">
                        <div class="accordion-body">
                            He wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="privacy-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#privacy-collapseFour" aria-expanded="false" aria-controls="privacy-collapseFour">
                            Why is privacy so important?
                        </button>
                    </h2>
                    <div id="privacy-collapseFour" class="accordion-collapse collapse" aria-labelledby="privacy-headingFour" data-bs-parent="#privacy-accordion">
                        <div class="accordion-body">
                            Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis aliquam ultrices mauris.
                        </div>
                    </div>
                </div>
            </div>
            <!--end accordion-->
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection
@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection

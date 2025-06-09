@extends('layouts.app')

@section('title', 'FAQs')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 style="font-size: 21px;">FAQs</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">FAQs</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-lead">Find answers to common questions about the TOEIC exam.</p>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div id="accordion-faqs">
                                @forelse ($faqs as $index => $faq)
                                    <div class="accordion">
                                        <div class="accordion-header" data-toggle="collapse" data-target="#faq-{{ $faq->faq_id }}">
                                            <h4>{{ $faq->question }} <i class="fas fa-chevron-down" style="float: right;"></i></h4>
                                        </div>
                                        <div id="faq-{{ $faq->faq_id }}" class="accordion-body collapse" data-parent="#accordion-faqs">
                                            <p>{!! nl2br(e($faq->answer)) !!}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p>No FAQs available at the moment.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
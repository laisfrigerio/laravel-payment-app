@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Make a payment</div>

                <div class="card-body">
                    <form action="{{ route("pay") }}" method="POST" id="form-payment">
                        @csrf
                        <div class="row">
                            <div class="col-auto">
                                <label for="value">How much you want pay?</label>
                                <input
                                    id="value"
                                    type="number"
                                    min="5"
                                    step="0.01"
                                    class="form-control"
                                    name="value"
                                    value="{{ mt_rand(500, 100000) / 100 }}"
                                >
                                <small class="form-text text-muted">
                                    Use values with up to two decimal positions, using a dot "."
                                </small>
                            </div>
                            <div class="col-auto">
                                <label for="currency">Currency</label>
                                <select id="currency" name="currency" class="custom-select form-control" required>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->iso }}">{{ strtoupper($currency->iso) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="platform">Select a desired platform</label>
                                <div class="form-group" id="toggler">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        @foreach($platforms as $platform)
                                            <label data-target="#{{ $platform->name }}-collapse" data-toggle="collapse" for="platform-img" class="btn btn-outline-primary rounded m-2 p-1">
                                                <input
                                                id="platform-img"
                                                type="radio"
                                                name="payment-platform"
                                                value="{{ $platform->id }}"
                                                required
                                                >
                                                <img title="{{ $platform->name }}" alt="{{ $platform->name }}" class="img-thumbnail" src="{{ asset($platform->image) }}" />
                                            </label>
                                        @endforeach
                                    </div>
                                    @foreach($platforms as $platform)
                                        <div
                                            id="{{ $platform->name }}-collapse"
                                            class="collapse"
                                            data-parent="#toggler">
                                            @includeIf("components." . strtolower($platform->name) . "-collapse")
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" id="btn-submit-pay" class="btn btn-primary btn-lg">Pay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('ngo.layout.master')
@section('content')
    <style>
        .gmail-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 25px 30px;
            margin-top: 30px;
        }

        .gmail-header {
            font-size: 22px;
            font-weight: 500;
            margin-bottom: 20px;
            color: #202124;
        }

        .gmail-meta {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .gmail-avatar {
            width: 48px;
            height: 48px;
            background-color: #d2d7e2;
            border-radius: 50%;
            margin-right: 15px;
            margin-bottom: 10px;
        }

        .gmail-sender-name {
            font-weight: 600;
            color: #1a73e8;
        }

        .gmail-sender-email {
            font-size: 0.9em;
            color: #5f6368;
        }

        .gmail-message {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 20px;
            white-space: pre-wrap;
            color: #202124;
            font-size: 15px;
            line-height: 1.6;
        }

        .gmail-btn {
            background: #f1f3f4;
            border: 1px solid #dadce0;
            border-radius: 20px;
            padding: 6px 20px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
            color: #3c4043;
            transition: background 0.2s;
        }

        .gmail-btn:hover {
            background-color: #e8eaed;
        }

        textarea.form-control {
            border-radius: 8px;
            border: 1px solid #dadce0;
            resize: vertical;
        }
    </style>
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Email</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Email</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="container">
            <div class="gmail-container mx-auto">
                {{-- Email Subject --}}
                <div class="gmail-header">
                    {{ $email->subject }}
                </div>

                {{-- Sender Info --}}
                <div class="gmail-meta row">
                    <div class="gmail-avatar col-auto"></div>
                    <div class="gmail-sender-info col">
                        <div class="gmail-sender-name">{{ $email->name }}</div>
                        <div class="gmail-sender-email">&lt;{{ $email->email }}&gt; to me</div>
                    </div>
                </div>

                {{-- Email Message --}}
                <div class="gmail-message">
                    {{ $email->message }}
                </div>

                {{-- Action Buttons --}}
                {{-- <div class="gmail-actions">
                <form action="{{ route('reply.email', $email->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="reply_message" class="form-control" rows="4" placeholder="Reply..." required>{{ old('reply_message') }}</textarea>
                    </div>
                    <button type="submit" class="gmail-btn">
                        <span>📩</span> Send
                    </button>
                </form>
            </div> --}}
            </div>
        </div>
    @endsection

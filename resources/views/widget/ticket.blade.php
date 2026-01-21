<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <script src="https://cdn.tailwindcss.com"></script>

    <title>Ticket Widget</title>

    <script>
        window.TICKET_WIDGET = {
            apiUrl: "{{ config('widget.api_url') }}",
        };
    </script>
</head>
<body class="bg-transparent">
<div class="min-h-screen p-4">
    <div class="mx-auto max-w-md rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 p-5">
            <h1 class="text-lg font-semibold text-slate-900">Support Ticket</h1>
            <p class="mt-1 text-sm text-slate-500">Send a request — we’ll reply by email.</p>
        </div>

        <div class="p-5">
            {{-- Alerts --}}
            <div id="alertSuccess" class="hidden mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                Sent. We’ll get back to you soon.
            </div>

            <div id="alertError" class="hidden mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                Something went wrong. Please try again.
            </div>

            {{-- Validation list --}}
            <div id="alertValidation" class="hidden mb-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                <div class="font-medium">Fix these fields:</div>
                <ul id="validationList" class="mt-2 list-disc pl-5"></ul>
            </div>

            <form id="ticketWidgetForm"
                  method="POST"
                  action="/api/tickets"
                  enctype="multipart/form-data"
                  class="space-y-4"
            >
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-800">Name</label>
                    <input id="customer_name" name="customer_name" type="text" autocomplete="name"
                           class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none ring-0 focus:border-slate-400"
                           placeholder="Your name"
                           required>
                    <p class="mt-1 text-xs text-rose-600 hidden" data-error-for="customer_name"></p>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-800">Email</label>
                    <input id="customer_email" name="customer_email" type="email" autocomplete="email"
                           class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none ring-0 focus:border-slate-400"
                           placeholder="you@example.com"
                           required>
                    <p class="mt-1 text-xs text-rose-600 hidden" data-error-for="customer_email"></p>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-slate-800">Phone</label>
                    <input id="customer_phone" name="customer_phone" type="tel" autocomplete="tel"
                           class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none ring-0 focus:border-slate-400"
                           placeholder="+380..."
                           required>
                    <p class="mt-1 text-xs text-rose-600 hidden" data-error-for="customer_phone"></p>
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-slate-800">Subject</label>
                    <input id="subject" name="subject" type="text"
                           class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none ring-0 focus:border-slate-400"
                           placeholder="What’s the issue?"
                           required>
                    <p class="mt-1 text-xs text-rose-600 hidden" data-error-for="subject"></p>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-slate-800">Message</label>
                    <textarea id="message" name="message" rows="5"
                              class="mt-1 w-full resize-none rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none ring-0 focus:border-slate-400"
                              placeholder="Describe the problem"
                              required></textarea>
                    <p class="mt-1 text-xs text-rose-600 hidden" data-error-for="message"></p>
                </div>

                <div>
                    <label for="files" class="block text-sm font-medium text-slate-800">Files</label>
                    <input id="files" name="files[]" type="file" multiple
                           class="mt-1 block w-full text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-slate-800"
                    />
                    <p class="mt-1 text-xs text-slate-500">Attach screenshots/logs (multiple allowed).</p>
                    <p class="mt-1 text-xs text-rose-600 hidden" data-error-for="files"></p>

                    <div id="filesPreview" class="mt-2 hidden rounded-xl border border-slate-200 bg-slate-50 p-3 text-sm text-slate-700">
                        <div class="font-medium text-slate-800">Selected:</div>
                        <ul id="filesList" class="mt-2 list-disc pl-5"></ul>
                    </div>
                </div>

                <div class="pt-2">
                    <button id="btnSend" type="button"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-60">
                        <span id="btnText">Send</span>
                        <svg id="btnSpinner" class="hidden h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </button>

                    <p class="mt-2 text-center text-xs text-slate-500">
                        By sending you agree to be contacted about this request.
                    </p>
                </div>

                <input type="hidden" name="source" value="iframe_widget">
            </form>
        </div>
    </div>
</div>

<script src="{{asset('js/widget.js')}}"></script>
</body>
</html>

<div class="row px-3">
    <div class="col-lg-12">
        <div class="m-2">
            <div class="w-100 d-flex justify-content-between mb-4">
                <h2>FAQ</h2>
                <button class="btn btn-primary" wire:click="toggleForm">{{ $formState ? 'Close' : 'Add FAQ' }}</button>
            </div>

            @if ($formState)
                <div class="card">
                    <div class="card-header">Add/Update FAQ</div>
                    <div class="card-body">
                        <form wire:submit="save">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="question">Question</label>
                                        <input class="form-control @error('question') is-invalid @enderror"
                                            id="question" type="text" wire:model="question" />
                                        @error('question')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="answer">Answer</label>
                                        <textarea class="form-control @error('answer') is-invalid @enderror" id="answer" type="text" wire:model="answer"></textarea>
                                        @error('answer')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled"
                                        wire:target="save">
                                        <div class="spinner-border spinner-border-sm" role="status" wire:loading
                                            wire:target="save">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span wire:loading wire:target="save"> Saving ...</span>
                                        <span wire:loading.remove wire:target="save">Save/Update</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            @if (!$formState)
                <div class="card">
                    <div class="card-header w-100">
                        <div class="w-100 d-flex justify-content-between">
                            <input class="form-control w-auto" type="search" placeholder="search ..."
                                wire:model.live="search" />
                            <select class="form-control w-auto" wire:model.live="limit">
                                <option value="5">5 Results</option>
                                <option value="10">10 Results</option>
                                <option value="20">20 Results</option>
                                <option value="30">30 Results</option>
                                <option value="50">50 Results</option>
                                <option value="100">100 Results</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-bordered datatablecl table">
                                <thead>
                                    <tr>
                                        <th class="text-start">S.No</th>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($faqs as $faq)
                                        <tr>
                                            <td class="text-start"><b>{{ $loop->index + 1 }}</b></td>
                                            <td>{{ $faq->question }}</td>
                                            <td>{{ $faq->answer }}</td>
                                            <td>
                                                <div class="form-check form-switch" wire:click="changeStatus({{ $faq->id }}, `{{ $faq->status ? 'true' : 'false' }}`)">
                                                    <input class="form-check-input" {{ $faq->status ? 'checked' : '' }} id="faq-status-{{ $faq->id }}" wire:click="changeStatus({{ $faq->id }}, `{{ $faq->status ? 'true' : 'false' }}`)"
                                                        type="checkbox" role="switch">
                                                    <label class="form-check-label" for="faq-status-{{ $faq->id }}" wire:click="changeStatus({{ $faq->id }}, `{{ $faq->status ? 'true' : 'false' }}`)">{{ $faq->status ? 'Active' : 'Inactive' }}</label>
                                                </div>
                                            </td>
                                            <td class="items-end text-end">
                                                <button class="btn btn-sm btn-primary" type="button"
                                                    wire:click="editFaq({{ $faq->id }}, '{{ $faq->question }}', '{{ $faq->answer }}')">Edit</button>
                                                <button class="btn btn-sm btn-danger" type="button"
                                                    wire:click="deleteFaq({{ $faq->id }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="deleteFaq({{ $faq->id }})">
                                                    <div class="spinner-border spinner-border-sm" role="status"
                                                        wire:loading wire:target="deleteFaq({{ $faq->id }})">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                    <span wire:loading wire:target="deleteFaq({{ $faq->id }})">
                                                        Deleting ...</span>
                                                    <span wire:loading.remove
                                                        wire:target="deleteFaq({{ $faq->id }})">Delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">{{ $faqs->links() }}</div>
                </div>
            @endif

        </div>
    </div>
</div>

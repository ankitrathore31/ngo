@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Add Member Position</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Position</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <td>Application No.</td>
                                <th>Registration No.</th>
                                <th>Name</th>
                                <th>Father/Husband Name</th>
                                <th>Address</th>
                                <th>Identity No.</th>
                                <th>Identity Type</th>
                                <th>Mobile No.</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Age</th>
                                <th>Status</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($member as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->application_no }}</td>
                                    <td>{{ $item->registration_no ?? 'Not Found' }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->gurdian_name }}</td>
                                    <td>{{ $item->village }},
                                        {{ $item->post }},
                                        {{ $item->block }},
                                        {{ $item->district }},
                                        {{ $item->state }} - {{ $item->pincode }},
                                        ({{ $item->area_type }})
                                    </td>
                                    <td>{{ $item->identity_no }}</td>
                                    <td>{{ $item->identity_type }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->caste }}</td>
                                    <td>{{ $item->religion_category }}</td>
                                    <td>{{ $item->religion }}</td>
                                    <td>
                                        {{ $item->dob ? \Carbon\Carbon::parse($item->dob)->age . ' years' : 'Not Found' }}
                                    </td>
                                    <td>
                                        @if ($item->status == 1)
                                            Approve
                                        @endif
                                    </td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm px-3"
                                                data-bs-toggle="modal" data-bs-target="#positionModal"
                                                onclick="setMemberId({{ $item->id }})">
                                                Add Position
                                            </a>
                                            <a href="{{ route('view-member', $item->id) }}"
                                                class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="View" style="min-width: 38px; height: 38px;">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="positionModal" tabindex="-1" aria-labelledby="positionModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('save-member-position') }}" method="POST">
                        @csrf
                        <input type="hidden" name="member_id" id="member_id">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">पद चयन फॉर्म (Select Position)</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="position_type" class="form-label">स्तर चुनें (Select Level)</label>
                                    <select class="form-select" id="position_type" name="position_type"
                                        onchange="updatePositions()" required>
                                        <option selected disabled>स्तर चुनें</option>
                                        <option value="rashtriya">राष्ट्रीय स्तर</option>
                                        <option value="pradesh">प्रदेश स्तर</option>
                                        <option value="mandal">मंडल स्तर</option>
                                        <option value="jila">जिला स्तर</option>
                                        <option value="nagar">नगर स्तर</option>
                                        <option value="block">ब्लॉक स्तर</option>
                                        <option value="gram">ग्राम स्तर</option>
                                    </select>
                                </div>

                                <div class="mb-3" id="position-box" style="display: none;">
                                    <label for="position" class="form-label">पद चुनें (Select Post)</label>
                                    <select class="form-select" id="position" name="position" required>
                                        <option selected disabled>पद चुनें</option>
                                    </select>
                                    <div class="mb-2 mt-1">
                                        <label for="" class="form-label">Working Area</label>
                                        <input type="text" class="form-control" name="working_area" required>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save Position</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const positionsByLevel = {
            rashtriya: ["राष्ट्रीय अध्यक्ष", "राष्ट्रीय उपाध्यक्ष 1", "राष्ट्रीय उपाध्यक्ष 2", "राष्ट्रीय उपाध्यक्ष 3",
                "राष्ट्रीय उपाध्यक्ष 4", "राष्ट्रीय महासचिव", "राष्ट्रीय सचिव", "राष्ट्रीय कोषाध्यक्ष",
                "राष्ट्रीय संगठन मंत्री", "जिला प्रभारी", "राष्ट्रीय सदस्य"
            ],
            pradesh: ["प्रदेश अध्यक्ष", "प्रदेश उपाध्यक्ष 1", "प्रदेश उपाध्यक्ष 2", "प्रदेश उपाध्यक्ष 3",
                "प्रदेश उपाध्यक्ष 4", "प्रदेश महासचिव", "प्रदेश सचिव", "प्रदेश कोषाध्यक्ष", "प्रदेश संगठन मंत्री",
                "प्रदेश प्रभारी", "प्रदेश सदस्य"
            ],
            mandal: ["मंडल अध्यक्ष", "मंडल उपाध्यक्ष 1", "मंडल उपाध्यक्ष 2", "मंडल उपाध्यक्ष 3", "मंडल उपाध्यक्ष 4",
                "मंडल महासचिव", "जिला सचिव", "मंडल कोषाध्यक्ष", "मंडल संगठन मंत्री", "मंडल प्रभारी", "मंडल सदस्य"
            ],
            jila: ["जिला अध्यक्ष", "जिला उपाध्यक्ष 1", "जिला उपाध्यक्ष 2", "जिला उपाध्यक्ष 3", "जिला उपाध्यक्ष 4",
                "जिला महासचिव", "जिला सचिव", "जिला कोषाध्यक्ष", "जिला संगठन मंत्री", "जिला प्रभारी", "जिला सदस्य"
            ],
            nagar: ["नगर अध्यक्ष", "नगर प्रभारी", "मोहल्ला प्रभारी", "मोहल्ला संचालक", "तहसील प्रभारी"],
            block: ["ब्लॉक अध्यक्ष", "ब्लॉक उपाध्यक्ष", "ब्लॉक कोषाध्यक्ष", "ब्लॉक सचिव", "ब्लॉक संगठन मंत्री",
                "ब्लॉक सदस्य"
            ],
            gram: ["ग्राम प्रभारी", "ग्राम अध्यक्ष", "ग्राम सचिव", "ग्राम कोषाध्यक्ष", "ग्राम सदस्य"]
        };

        function updatePositions() {
            const position_type = document.getElementById("position_type").value;
            const positionSelect = document.getElementById("position");
            positionSelect.innerHTML = '<option selected disabled>पद चुनें</option>';

            if (positionsByLevel[position_type]) {
                positionsByLevel[position_type].forEach(function(pos) {
                    const option = document.createElement("option");
                    option.text = pos;
                    option.value = pos;
                    positionSelect.add(option);
                });
                document.getElementById("position-box").style.display = "block";
            } else {
                document.getElementById("position-box").style.display = "none";
            }
        }

        function setMemberId(id) {
            document.getElementById("member_id").value = id;
        }
    </script>
@endsection

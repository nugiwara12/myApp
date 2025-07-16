@php
    use App\Models\BarangayId;
    use App\Models\Indigency;
    use App\Models\Residency;

    // Individual counts (for display in Request Type Cards)
    $barangayIdCount = BarangayId::count();
    $indigencyCount = Indigency::count();
    $residencyCount = Residency::count();

    // Total
    $totalRequests = $barangayIdCount + $indigencyCount + $residencyCount;

    // Approved
    $approvedCount = BarangayId::where('approved_by', '!=', '0')->count()
        + Indigency::where('approved_by', '!=', '0')->count()
        + Residency::where('approved_by', '!=', '0')->count();

    // Pending
    $pendingCount = BarangayId::where('approved_by', '0')->count()
        + Indigency::where('approved_by', '0')->count()
        + Residency::where('approved_by', '0')->count();
@endphp



<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-blue-100 rounded-full shadow">
                <i class="bi bi-speedometer2 text-blue-600 text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Welcome back!</h1>
                <p class="text-sm text-gray-500">Here's an overview of your request activity</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- 🔹 Summary Cards (General) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-blue-50 p-5 rounded-lg shadow text-center">
                    <div class="text-sm text-gray-500">Total Requests</div>
                    <div class="text-2xl font-bold text-blue-600">{{ $totalRequests }}</div>
                </div>
                <div class="bg-green-50 p-5 rounded-lg shadow text-center">
                    <div class="text-sm text-gray-500">Approved</div>
                    <div class="text-2xl font-bold text-green-600">{{ $approvedCount }}</div>
                </div>
                <div class="bg-yellow-50 p-5 rounded-lg shadow text-center">
                    <div class="text-sm text-gray-500">Pending</div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $pendingCount }}</div>
                </div>
            </div>


            <!-- 🔹 Request Type Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-indigo-50 p-5 rounded-lg shadow text-center">
                    <div class="text-sm text-gray-500">Residence Requests</div>
                    <div class="text-2xl font-bold text-indigo-600" id="residenceCount">{{ $residencyCount }}</div>
                </div>
                <div class="bg-cyan-50 p-5 rounded-lg shadow text-center">
                    <div class="text-sm text-gray-500">Indigency Requests</div>
                    <div class="text-2xl font-bold text-cyan-600" id="indigencyCount">{{ $indigencyCount }}</div>
                </div>
                <div class="bg-purple-50 p-5 rounded-lg shadow text-center">
                    <div class="text-sm text-gray-500">Barangay ID Requests</div>
                    <div class="text-2xl font-bold text-purple-600" id="barangayIdCount">{{ $barangayIdCount }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<template>
    <div>
        <h5 class="mb-4">Company Profile</h5>

        <div class="mb-3">
            <label class="form-label">Company Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" v-model="formData.company_name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Address <span class="text-danger">*</span></label>
            <input type="text" class="form-control" v-model="formData.address" placeholder="Unit, Building, Street" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">City/Town <span class="text-danger">*</span></label>
                <input type="text" class="form-control" v-model="formData.city" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Region/State <span class="text-danger">*</span></label>
                <input type="text" class="form-control" v-model="formData.region" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Country <span class="text-danger">*</span></label>
                <select class="form-select" v-model="formData.country" required>
                    <option value="" disabled>Select Country</option>
                    <option value="Philippines">Philippines</option>
                    <option value="United States">United States</option>
                    <option value="Japan">Japan</option>
                    <option value="Singapore">Singapore</option>
                    <option value="China">China</option>
                    <option value="Australia">Australia</option>
                    <!-- Add more as needed -->
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Year Established <span class="text-danger">*</span></label>
                <input type="number" class="form-control" v-model="formData.year_established" placeholder="YYYY" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Website <span class="text-muted">(Optional)</span></label>
            <input type="url" class="form-control" v-model="formData.website" placeholder="https://example.com">
        </div>

        <div class="mb-4">
            <label class="form-label">Company Brochure <span class="text-muted">(PDF/DOC, Max 2MB)</span></label>
            <input type="file" class="form-control" @change="handleFileUpload" accept=".pdf,.doc,.docx">
            <div v-if="formData.brochure" class="form-text text-success">
                Selected: {{ formData.brochure.name }}
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button class="btn btn-secondary px-4" @click="$emit('prev')">Back</button>
            <button class="btn btn-primary px-4" @click="validateAndNext">Next Step</button>
        </div>
    </div>
</template>

<script setup>
const props = defineProps(['formData']);
const emit = defineEmits(['prev', 'next']);

const handleFileUpload = (event) => {
    // Update the reactive object with the File object directly
    props.formData.brochure = event.target.files[0];
};

const validateAndNext = () => {
    if (!props.formData.company_name || !props.formData.country || !props.formData.year_established) {
        alert("Please complete the required company details.");
        return;
    }
    emit('next');
};
</script>
<template>
    <div>
        <h5 class="mb-4">Review Your Information</h5>

        <div class="alert alert-info border-0">
            Please review your details below before submitting.
        </div>

        <div class="card mb-3">
            <div class="card-header bg-light fw-bold">Account Details</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Name:</span>
                    <span class="fw-medium">{{ formData.first_name }} {{ formData.last_name }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Email:</span>
                    <span class="fw-medium">{{ formData.email }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Username:</span>
                    <span class="fw-medium">{{ formData.username }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Type:</span>
                    <span class="badge bg-secondary">{{ formData.type }}</span>
                </li>
            </ul>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">Company Profile</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Company:</span>
                    <span class="fw-medium">{{ formData.company_name }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Location:</span>
                    <span class="fw-medium text-end">{{ formData.city }}, {{ formData.region }}, {{ formData.country }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Established:</span>
                    <span class="fw-medium">{{ formData.year_established }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Website:</span>
                    <span class="fw-medium">{{ formData.website || 'N/A' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Brochure:</span>
                    <span class="fw-medium" :class="formData.brochure ? 'text-success' : 'text-secondary'">
                        {{ formData.brochure ? formData.brochure.name : 'No file uploaded' }}
                    </span>
                </li>
            </ul>
        </div>

        <div v-if="Object.keys(errors).length > 0" class="alert alert-danger">
            <ul class="mb-0">
                <li v-for="(errorMsg, field) in errors" :key="field">
                    {{ errorMsg[0] }}
                </li>
            </ul>
        </div>

        <div class="d-flex justify-content-between">
            <button class="btn btn-fame-outline px-4" @click="$emit('prev')" :disabled="loading">Back</button>
            <button class="btn btn-success px-4" @click="$emit('submit')" :disabled="loading">
                <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
                <span v-if="loading">Submitting...</span>
                <span v-else>Confirm & Register</span>
            </button>
        </div>
    </div>
</template>

<script setup>
defineProps(['formData', 'loading', 'errors']);
defineEmits(['prev', 'submit']);
</script>
<template>
    <div>
        <h5 class="mb-4">Account Details</h5>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" v-model="formData.first_name" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" v-model="formData.last_name" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address <span class="text-danger">*</span></label>
            <input type="email" class="form-control" v-model="formData.email" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Username <span class="text-danger">*</span></label>
            <input type="text" class="form-control" v-model="formData.username" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" v-model="formData.password" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" v-model="formData.password_confirmation" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Participation Type <span class="text-danger">*</span></label>
            <select class="form-select" v-model="formData.type" required>
                <option value="Buyer">Buyer</option>
                <option value="Exhibitor">Exhibitor</option>
                <option value="Visitor">Visitor</option>
            </select>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-fame px-4" @click="validateAndNext">
                Next Step <i class="bi bi-arrow-right"></i>
            </button>
        </div>
    </div>
</template>

<script setup>
const props = defineProps(['formData']);
const emit = defineEmits(['next']);

const validateAndNext = () => {
    if (!props.formData.first_name || !props.formData.email || !props.formData.password) {
        alert("Please fill in all required fields.");
        return;
    }
    
    if (props.formData.password !== props.formData.password_confirmation) {
        alert("Passwords do not match.");
        return;
    }

    emit('next');
};
</script>
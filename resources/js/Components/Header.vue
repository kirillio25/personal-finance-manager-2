<template>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h2>Панель управления</h2>
        <div class="d-flex align-items-center">
            <span class="me-3">{{ auth.user.name }}</span>
            <form method="POST" :action="route('logout')">
                <input type="hidden" name="_token" :value="csrfToken">
                <button type="submit" class="btn btn-outline-danger">Выйти</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        auth: Object,  
        csrfToken: String 
    }
}
</script>


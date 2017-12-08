<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Choose method you need</div>

                    <div class="panel-body">
                        <router-link tag="li" to="/geocoding">
                            <a>Geocoding</a>
                        </router-link>
                        <router-link tag="li" to="/reverse">
                            <a>Reverse Geocoding</a>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
    }
</script>

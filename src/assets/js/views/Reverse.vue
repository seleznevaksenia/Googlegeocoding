<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Form<router-link class="pull-right" :to="{ path: '/'}">
                        <span class="glyphicon glyphicon-home"></span></router-link></div>

                    <div class="panel-body">
                        <form method="POST" action="#">
                            <div class="form-group ">
                                <label for="latitude">Latitude</label>
                                <input type="text" name="user_id" class="form-control" id="latitude"
                                       v-model=latitude
                                       placeholder="Latitude" required>
                            </div>
                            <div class="form-group ">
                                <label for="longitude">Longitude</label>
                                <input type="text" name="user_id" class="form-control" id="longitude"
                                       v-model=longitude
                                       placeholder="Longitude" required>
                            </div>
                            <div class="form-group">
                                <label for="language">Select language</label>
                                <select class="form-control" id="language" v-model="language">
                                    <option v-for="item in languages" :value="item.key">{{item.value}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-inline"><input type="checkbox" @change="getPostalCode" value=""
                                                                      id="postalCode">Postal Code</label>
                            </div>
                            <button type="submit" @click.prevent="getAddress" class="btn btn-default btn-block">
                                Get Response
                            </button>
                        </form>
                        <label>Result:</label>
                        <div class="list-group" v-if="response !== ''">
                            <ul  class="list-group">
                                <li class="list-group-item">Address:{{formattedAddress}}</li>
                                <li  v-if="response.postalCode !== null" class="list-group-item">Postal Code:{{postalCode_}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                longitude: '',
                latitude:'',
                languages: {
                    0: {
                        'key': 'ar',
                        'value': 'Arabic'
                    },
                    1: {
                        'key': 'de',
                        'value': 'German'
                    },
                    2: {
                        'key': 'en',
                        'value': 'English'
                    },
                    3: {
                        'key': 'fr',
                        'value': 'French'
                    }
                },
                response: '',
                language: '',
                postalCode: false
            }
        },
        computed: {
            formattedAddress() {
                return this.response.formattedAddress;
            },
            postalCode_() {
                return  this.response.postalCode;
            },
        },
        created() {
            this.language = 'en';
        },
        methods: {
            getAddress() {
                axios.get('/rev/?language=' + this.language + '&longitude=' + this.longitude + '&latitude=' + this.latitude
                    + '&postalCode='+ this.postalCode)
                    .then(({data}) => {
                            this.response = data;
                        }
                    );
            },
            getPostalCode() {
                if ($('#postalCode').is(':checked')) {
                    this.postalCode = true;
                }
                else {
                    this.postalCode = false;
                }
            }
        }
    }
</script>

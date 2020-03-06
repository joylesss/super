<template>
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <slot name="title"></slot>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col" v-for="thead in theads" v-if="thead.sort" @click="sort(thead.key)">
                            {{thead.title}}
                            <span v-if="params.sort_column === thead.key">
                                <i class="fas fa-sort-down" v-if="params.direction === 'desc'"></i>
                                <i class="fas fa-sort-up" v-else></i>
                            </span>
                        </th>
                        <th scope="col" v-else>
                            {{thead.title}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <slot name="tbody" :items="model.data">
                            <!-- Call to user component and return results -->
                        </slot>
                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation example" :class="[(urlUser)]">
                <ul class="pagination">
                    <li class="page-item" :class="[(model.prev_page_url === null) ? 'disabled' : '']">
                        <a class="page-link" href="#" @click="prev()" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item" :class="[(params.page === n) ? 'active' : '']" v-for="n in numberWithDots">
                        <a class="page-link" href="#" @click="changePerPage(n)">{{n}}</a>
                    </li>
                    <li class="page-item" :class="[(model.next_page_url === null) ? 'disabled' : '']">
                        <a class="page-link" href="#" @click="next()" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
    import {apiRequest} from "../helpers/apiRequest";
    import {buildUrl} from "../helpers/buildUrl";
    import {pagination} from "../helpers/pagination";

    export default {
        props: ['theads', 'params', 'urlUser'],
        data() {
            return {
                model: {
                    data: []
                },
                numberWithDots: []
            }
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                apiRequest('/api/profile/users' + buildUrl(this.params))
                    .then(res => {
                        let m = res.model;
                        this.model = m;
                        this.numberWithDots = pagination(m.current_page, m.last_page)
                    })
                    .catch(err => console.log(err))
            },
            changePerPage(page) {
                event.preventDefault();
                if (page === '...') return false;
                this.params.page = page;
                this.fetchData();

            },
            prev() {
                event.preventDefault();
                this.params.page--;
                this.fetchData();
            },
            next() {
                event.preventDefault();
                this.params.page++;
                this.fetchData();
            },
            sort(column) {
                this.params.sort_column = column;
                if (this.params.direction === 'desc') {
                    this.params.direction = 'asc';
                } else {
                    this.params.direction = 'desc';
                }
                this.fetchData();
            }
        }
    }
</script>
<style>
    .page-link:focus {
        box-shadow: none;
    }
</style>

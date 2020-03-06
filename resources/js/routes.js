import User from './components/profile/UserComponent';
import App from './components/profile/AppComponent';
import Score from './components/profile/ScoreComponent';
import Question from './components/profile/QuestionComponent';
import Win from './components/profile/WinComponent';

const routes = [
    {path: '/profile/users', name: 'userList', component: User},
    {path: '/profile/apps', name: 'appList', component: App},
    {path: '/profile/scores', name: 'scoreList', component: Score},
    {path: '/profile/questions', name: 'questionList', component: Question},
    {path: '/profile/wins', name: 'winList', component: Win},
];

export default routes;

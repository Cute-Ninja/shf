import React from "react";
import { Route, NavLink, HashRouter} from "react-router-dom";
import Home from "./components/home/Home"
import Workouts from "./components/workout/Workouts";
import User from "./components/user/User";

class App extends React.Component {
    render() {
        return (
            <HashRouter>
                <div>
                    <h1>Simple SPA</h1>
                    <ul className="header">
                        <li><NavLink to="/">Home</NavLink></li>
                        <li><NavLink to="/workouts">Workouts</NavLink></li>
                        <li><NavLink to="/profile">Profile</NavLink></li>
                    </ul>
                    <div className="content">
                        <Route path="/" component={Home}/>
                        <Route path="/workouts" component={Workouts}/>
                        <Route path="/profile" component={User}/>
                    </div>
                </div>
            </HashRouter>
        );
    }
}

export default App;
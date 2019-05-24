import React from "react";
import { Switch, Route, Link, BrowserRouter} from "react-router-dom";
import NotFound from "./components/error/NotFound";
import Home from "./components/home/Home";
import Workout from "./components/workout/Workout";
import Workouts from "./components/workout/Workouts";
import User from "./components/user/User";

class App extends React.Component {
    render() {
        return (
            <BrowserRouter>
                <div>
                    <h1>Simple SPA</h1>
                    <ul className="header">
                        <li><Link to="/">Home</Link></li>
                        <li><Link to="/workouts">Workouts</Link></li>
                        <li><Link to="/profile">Profile</Link></li>
                    </ul>
                    <div className="content">
                        <Switch>
                            <Route exact path="/" component={Home}/>
                            <Route exact path="/workout/:id" component={Workout}/>
                            <Route exact path="/workouts" component={Workouts}/>
                            <Route exact path="/profile" component={User}/>
                            <Route component={NotFound}/>
                        </Switch>
                    </div>
                </div>
            </BrowserRouter>
        );
    }
}

export default App;
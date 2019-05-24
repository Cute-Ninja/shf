import React from "react";
import { Link } from "react-router-dom";
import ApiClient from "../common/ApiClient";

class Workouts extends React.Component {

    constructor() {
        super();
        this.state = {
            isLoaded: false,
            workouts: []
        };
    }

    componentDidMount() {
        ApiClient.getMany("/api/workouts")
            .then((result) => {
                this.setState({
                    isLoaded: true,
                    workouts: result.data
                });
            });
    }

    render() {
        const { isLoaded, workouts } = this.state;
        if (false === isLoaded ) {
            return <div>Loading...</div>
        }

        return (
            <ul>
                { workouts.map(workout =>
                    <li>
                        <Link to={ '/workout/' + workout.id}>
                            <h3>{ workout.name }</h3>
                        </Link>
                        <p>{ workout.description }</p>
                    </li>
                )}
            </ul>
        );
    }
}

export default Workouts;

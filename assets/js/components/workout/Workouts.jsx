import React from "react";
import Workout from "./Workout";

class Workouts extends React.Component {

    constructor() {
        super();
        this.state = {
            isLoaded: false,
            error: null,
            workouts: []
        }
    }

    componentDidMount() {
        fetch("/api/workouts")
            .then(res => res.json())
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        workouts: result
                    });
                },
                (error) => {
                    this.setState({
                        isLoaded: true,
                        error
                    });
                }
            );
    }

    render() {
        const { isLoaded, error, workouts } = this.state;

        if (error) {
            return <div>Error: {error.message}</div>;
        }

        if (false === isLoaded ) {
            return <div>Loading...</div>
        }

        return (
            <ul>
                { workouts.map(workout =>
                    <li><Workout workout={workout}/></li>
                )}
            </ul>
        );
    }
}

export default Workouts;

import React from "react";
import ApiClient from "../common/ApiClient";

class Workout extends React.Component {

    constructor() {
        super();
        this.state = {
            isLoaded:false,
            workout: null
        };
    }

    componentDidMount() {
        ApiClient.getOne("/api/workouts", this.props.match.params.id)
            .then((result) => {
                this.setState({
                    isLoaded: true,
                    workout: result
                });
            });
    }

    render() {
        const { isLoaded, workout } = this.state;
        if (false === isLoaded) {
            return <div>Loading...</div>
        }

        if (null === workout) {
            return (
                <div>No workout found for id { this.props.match.params.id }</div>
            )
        }

        return (
            <div>
                <h3>{ workout.name }</h3>
            </div>
        );
    }
}

export default Workout;

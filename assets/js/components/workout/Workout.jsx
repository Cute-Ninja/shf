import React from "react";

class Workout extends React.Component {

    constructor(props) {
        super();
        this.state = {
            workout: props.workout
        }
    }

    render() {
        const { workout } = this.state;
        return (
            <div>
                <h3>{ workout.name }</h3>
                <p>{ workout.description }</p>
            </div>
        );
    }
}

export default Workout;

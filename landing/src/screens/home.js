import React from 'react';
import DataAdapter from '../data/dataAdapter';
import ReactTable from 'react-table';
import 'react-table/react-table.css';
import { throwStatement } from '@babel/types';

export default class HomeScreen extends React.Component {
    _adapter = new DataAdapter();

    constructor(props) {
        super(props);
        this.state = {
            games: [],
            scores: [],
            currentSelection: undefined,
        };
    }

    componentDidMount() {
        this.loadGames();
    }

    render() {
        let listGames = this.state.games.map((item, key) =>  <li key={item.id} onClick={this.handleGameClick.bind(this,item)}>{item.name}</li> );
        return (
            <div>
                <ul className="game-list-container">
                    { listGames }
                </ul>
                <ReactTable data={this.state.scores} 
                            columns={this.getScoreColumns()}
                            defaultPageSize={10} />
            </div>
        );
    }

    async loadGames() {
        let response = await this._adapter.getGames();
        let json = await response.json();
        this.setState({games: json.data});
    }

    async loadScores(gameId) {
        let response = await this._adapter.getGameScores(gameId);
        let json = await response.json();
        this.setState({scores: json.data});
    }

    handleGameClick(item, e) {
        if (this.state.currentSelection !== undefined) {
            this.state.currentSelection.classList.remove('selected');
        }
        this.state.currentSelection = e.currentTarget;
        this.state.currentSelection.classList.add('selected');
        this.loadScores(item.id);
    }

    getScoreColumns() {
        let scoreColumns = [];
        this.state.scores.forEach((item) => {
            for (let prop in item.scores) {
                if (prop === "") { continue; }
                if (scoreColumns.indexOf(prop) === -1) {
                    scoreColumns.push(prop);
                }
            }
        });
        let sorted = scoreColumns.sort();
        let returnValue = [
            {
                Header: 'Name',
                accessor: 'player_name',
            },
            {
                Header: 'Timestamp',
                accessor: 'timestamp',
            }
        ];
        scoreColumns.forEach((item) => {
            returnValue.push({
                id: item,
                Header: item,
                accessor: value => {
                    return value.scores[item] ? Number(value.scores[item]) : 0;
                },
            });
        });
        return returnValue;
    }
}
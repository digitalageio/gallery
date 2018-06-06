class Player
{
	constructor(tetris)
 	{
 		this.DROP_SLOW = 1000;
 		this.DROP_FAST = 50;

 		this.events = new Events();

 		this.tetris = tetris;
 		this.arena = tetris.arena;

		this.pos = {x: 0, y: 0},
		this.matrix = null,
		this.type = 0,
		this.score = 0

		this.dropCounter = 0;
		this.dropInterval = this.DROP_SLOW;

		this.reset();
 	}

	createPiece(type){
		switch(type){
			case 't':
				return [
					[0, 0, 0],
					[1, 1, 1],
					[0, 1, 0]
				];
				break;
			case 'o':
				return [
					[2, 2, 0],
					[2, 2, 0],
					[0, 0, 0]
				];
				break;
			case 'l':
				return [
					[0, 3, 0],
					[0, 3, 0],
					[0, 3, 3]
				];
				break;
			case 'j':
				return [
					[0, 4, 0],
					[0, 4, 0],
					[4, 4, 0]
				];
				break;
			case 'i':
				return [
					[0, 5, 0, 0],
					[0, 5, 0, 0],
					[0, 5, 0, 0],
					[0, 5, 0, 0]
				];
				break;
			case 's':
				return [
					[0, 6, 6],
					[6, 6, 0],
					[0, 0, 0]
				];
				break;
			case 'z':
				return [
					[7, 7, 0],
					[0, 7, 7],
					[0, 0, 0]
				];
				break;
			default:
				break;
		}
	}

 	drop()
 	{
		this.pos.y++;
		this.dropCounter = 0;
		if(this.arena.collide(this)){
			this.pos.y--;
			this.arena.merge(this);
			this.reset();
			this.score += this.arena.sweep(this);
			this.events.emit('score', this.score);
			return;
		}
		this.events.emit('pos', this.pos);
	}

 	move(dir)
 	{
		this.pos.x += dir;
		if(this.arena.collide(this)){
			this.pos.x -= dir;
			return;
		}
		this.events.emit('pos', this.pos);
	}

	reset()
	{
		const pieces = 'iljotsz';
		this.matrix = this.createPiece(pieces[pieces.length * Math.random() | 0]);
		this.pos.y = 0;
		this.pos.x = (this.arena.matrix[0].length / 2 | 0) - (this.matrix[0].length / 2 | 0);
		if(this.arena.collide(this)){
			this.arena.clear();
			this.score = 0;
			this.events.emit('score', this.score);
		}
		this.events.emit('pos', this.pos);
		this.events.emit('matrix', this.matrix);
	}

	rotate(dir)
	{
		const pos = this.pos.x;
		let offset = 1;
		this._rotateMatrix(this.matrix, dir);
		while(this.arena.collide(this)){
			this.pos.x =+ offset;
			offset = -(offset + (offset > 0 ? 1 : -1));
			if(offset > this.matrix[0].length){
				this._rotateMatrix(this.matrix, -dir);
				this.pos.x = pos;
				return;
			}
		}
		this.events.emit('matrix', this.matrix);
	}

	_rotateMatrix(matrix, dir)
	{
		for(let y = 0; y < matrix.length; ++y){
			for(let x = 0; x < y; ++x){
				[
					matrix[x][y],
					matrix[y][x]
				] = [
					matrix[y][x],
					matrix[x][y]
				]
			}
		}

		if(dir > 0){
			matrix.forEach(row => row.reverse());
		} else {
			matrix.reverse();
		}
	}

	update(deltaTime)
	{
		this.dropCounter += deltaTime;
		if(this.dropCounter > this.dropInterval){
			this.drop();
			this.dropCounter = 0;
		}
	}
}